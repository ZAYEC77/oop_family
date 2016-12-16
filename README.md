# Чому я сам собі старший брат

Так сталося, що я часто пишу код.
І наслідком такого часопроводження бувають дивні речі.
Нам (програмістам) часто приходиться формалізувати об'єкти реального світу і "засовувати" їх в стрічки програмного коду.

І одного разу я вирішив формалізувати моделі сім'ї.
З цього і вийшов заголовок цієї статті.

Отож будемо писати код.

Давайте створемо модель людини:

```php
class Human
{
    public $name;

    protected $_id;

    protected static $nextId = 0;

    public function __construct($name)
    {
        $this->name = $name;
        $this->_id = ++self::$nextId;
    }

    public function getId()
    {
        return $this->_id;
    }
}

```

Для початку вистачить, тепер ми можемо створити декілька об'єктів.


```php
$father = new Human('Vasja');
```

Далі створимо клас для інформації про сім'ю:
```php
class Family
{
    protected $_parents = [];

    public function __construct($parents)
    {
        $this->_parents = $parents;
    }

    public function getChildren()
    {
        return array_reduce($this->_parents, function ($result, Human $parent) {
            return array_merge($result, $parent->getChildren());
        }, []);
    }

    public function getParents()
    {
        return $this->_parents;
    }

    public function addChild($human)
    {
        foreach ($this->_parents as $parent) {
            $parent->addChild($human);
        }
        return $human;
    }
}
```

До реалізації можна причепитися з багатьох сторін, але все ж, вважаю свою думку я сформулював.

Як бачимо, я також додав два методи до класу `Human`, тут все теж доволі банально, ось новий шматочок:

```php
    protected $_children = [];

    public function addChild(Human $human)
    {
        $this->_children[$human->getId()] = $human;
    }

    public function getChildren()
    {
        return $this->_children;
    }
```

Продовжимо далі імітувати реальний світ:

```php
$father = new Human('Father'); // був собі батько
$mother = new Human('Mother'); // і була собі мати

$family = new Family([$father, $mother]); // і вирішили вони створити сім'ю

$boy = $family->addChild(new Human('Boy')); // одного разу з'явився в них син
$boy2 = $family->addChild(new Human('Boy #2')); // а через деякий час ще один
```

І тут виникає наступне питання: "хто з дітей старший?".

А тут все просто -- старший той, в кого мешне значення id, об'єкт ж раніше в часі створили, все логічно.

(Якщо чесно, всілякі timestamp-и і created_at-и мені просто було лінь робити)

Питання вирішили, рушаємо далі.

Як ж визначити старшого брата для дитини в сім'ї? (слово "брат" може бути замінене на "сестра" в залежності від контексту, поняття статі я теж не хотів вводити, як то кажуть KISS)

Тут теж все банально:

- збираємо всіх дітей (метод  getChildren в класі сім'ї вже є)
- шукаємо найстаршого з цього списку

Поїхали!

Додаємо метод getOlderChild до класу Family

```php
    public function getOlderChild()
    {
        $children = $this->getChildren();

        usort($children, function (Human $a, Human $b) {
            return $a->getId() > $b->getId();
        });

        return array_shift($children);
    }
```


Іііі, останні штрихи:

```php
$olderChild = $family->getOlderChild();

if ($boy === $olderChild){
    echo 'My older brother is me :/';
}
```

Що і треба було довести: "Я сам собі старший брат"

Авжеж реалізувати все можна було ще мільйоном різних способів, але такий примітивний мені здався найбільш зрозумілим.

До нових зустрічей.