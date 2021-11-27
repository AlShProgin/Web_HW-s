console.log("Testing: forEach");
{
    //В данном примере итерируем объект по свойствам, как массив по элементам
    //стандартный forEach такое не позволяет
    function Msg (text, id){
        this.text = text;
        this.id = id;
        this.reply = () => {
            console.log(text);
        }
    }
    let test = [];
    for (let i=0; i<=5; i++){
        test[i] = new Msg("msg"+(i+1), i+1);
        console.log(`Received item #${i+1}`);

        _.forEach(test[i], function(value, key) {
            console.log(`${key}: ${value}`);
        })
    }
    console.log("////////////////////////////////////////////////////");
}
console.log("Testing: filter");
{
    //Создаём новый массив на основе старого, выбирая элементы по условию
    let test = [
        {id: 1, number: 15},
        {id: 2, number: 35},
        {id: 3, number: 10},
    ];
    console.log("Old collection: ");
    _.forEach(test, function(value) {
        console.log(`Received: ${value.id}, ${value.number}`);
    })

    console.log("Condition: number > 13")

    test = _.filter(test, function(obj){
        return (obj.number > 13);
    })
    console.log("New collection: ");
    _.forEach(test, function(value) {
        console.log(`Received: ${value.id}, ${value.number}`);
    })
    console.log("////////////////////////////////////////////////////");
}
console.log("Testing: without");
{
    //Возвращаем массив, содержащий указанный за исключением указанных элементов
    console.log("Pre-without array: ");
    let test = ["a", "c", 'b', `c`, "d"];
    _.forEach(test, function(value) {
        console.log(`Received: ${value}`);
    })

    console.log("Removing: c, f")

    test = _.without(test, `c`, "f");
    console.log("Post-without array");
    _.forEach(test, function(value) {
        console.log(`Received: ${value}`);
    })
}
console.log("Testing: remove");
{
    let test = [
        {name: 1, age: 15},
        {name: 2, age: 35},
        {name: 3, age: 10},
    ];
    console.log("Pre-remove array:");
    _.forEach(test, function(value) {
        console.log(`Received person: ${value.name}, ${value.age}`);
    })
    let leftovers = _.remove(test, function(obj){
        return obj.age < 20;
    })

    console.log("Condition: age < 20")

    console.log("Post-remove array:");
    _.forEach(test, function(value) {
        console.log(`Received person: ${value.name}, ${value.age}`);
    })
    console.log("Removed objects:");
    _.forEach(leftovers, function(value) {
        console.log(`Received person: ${value.name}, ${value.age}`);
    })
    console.log("//////////////////////////////////////////////");
}
console.log("Testing: every");
{
    let test= [
        {id: 1, number: 4},
        {id: 2, number: 7},
        {id: 3, number: 10},
        {id: 4, number: 13}
    ];
    console.log("The array:");
    _.forEach(test, function(value) {
        console.log(`Received person: ${value.id}, ${value.number}`);
    })
    console.log("Condition: not multiple of 3");
    console.log(_.every(test, function(obj){
        return obj.number % 3 != 0;
    }));
    console.log("Condition: < 0");
    console.log(_.every(test, function(obj){
        return obj.number < 0;
    }));
    console.log("///////////////////////////////////////////");
}
console.log("Testing: some");
{
    let test= [
        {id: 1, number: -1},
        {id: 2, number: 7},
        {id: 3, number: 10},
        {id: 4, number: 13}
    ];
    console.log("The array:");
    _.forEach(test, function(value) {
        console.log(`Received person: ${value.id}, ${value.number}`);
    })
    console.log("Condition: some elements are not multiple of 3");
    console.log(_.some(test, function(obj){
        return obj.number % 3 != 0;
    }));
    console.log("Condition: some elements are < 0");
    console.log(_.some(test, function(obj){
        return obj.number < 0;
    }));
    console.log("///////////////////////////////////////////////");
}
console.log("Testing: sortBy");
{
    let films = [
        {'chapter': 1, 'year': 1999 },
        {'chapter': 2, 'year': 2002 },
        {'chapter': 3, 'year': 2005 },
        {'chapter': 4, 'year': 1977 },
        {'chapter': 5, 'year': 1980 },
        {'chapter': 6, 'year': 1983 }
    ];
    console.log("Original order:");
    _.forEach(films, function(value) {
        console.log(`Received person: ${value.chapter}, ${value.year}`);
    })

    console.log("Sorting by year");

    films = _.sortBy(films, [function(o) { return o.year; }]);

    console.log("New order:");
    _.forEach(films, function(value) {
        console.log(`Received person: ${value.chapter}, ${value.year}`);
    })
    console.log("////////////////////////////////////////////");
}
console.log("Testing: parseInt");
{
    //Если коротко, то функция находит первый символ-не проблел,
    //и, если это цифра - собирает число до нахождение не числа
    //Иными словами, она берёт из строки первое целове число, если оно в начале
    console.log("Parsing: 08tr");
    console.log(_.parseInt('08tr', 10));
    test = " 1God I wish I could extract number 10 easily";
    console.log(`Parsing: ${test}`);
    console.log(_.parseInt(test));
    console.log("Parsing: e08tr");
    console.log(_.parseInt('e08tr', 10));
    console.log("//////////////////////////////////////////////");
}
console.log("Testing: uppercase");
{
    let test = "original string";
    console.log(test);
    console.log(_.upperCase(test));
    console.log("////////////////////////////////////////");
}
console.log("Testing: words");
{
    //Функция воспринимает раздельно цифры и буквы - даже будучи
    //написаными слитно, они считаются разными словами
    //лечится только регулярнми выражениями
    let test = "Word1, word2, 1w, w1, word3";
    console.log(`Original string: ${test}`);
    let words = _.words(test);
    console.log("Found words with no regex: ")
    _.forEach(words, function(value){
        console.log(`word: ${value}`);
    })
    words = _.words(test, /[^, ]+/g);
    console.log("Found words with regex /[^, ]+/g")
    _.forEach(words, function(value){
        console.log(`word: ${value}`);
    })
    console.log("//////////////////////////////");
}
console.log("Testing: partial");
{
    //Функция позволяет создать из начальной функции новую
    //через присваиванием заданным атрибутам значений по умолчанию
    //получаем функцию с меньшим число аргументов (меньшей арностью)
    //По умолчанию переопределяются аргументы по порядку слева направо
    //можно явно пропустить аргументы с помощью нижнего прочерка
    function multiply(a, b) {
        return a * b;
    }
    let double = _.partial(multiply, 2);
    console.log(`Doubling 5: ${double(5)}`);

    function divide(a, b) {
        return a / b;
    }
    var half = _.partial(divide, _, 2);
    console.log(`Dividing 8 in half: ${half(8)}`);
    console.log("///////////////////////////////////////////");
}