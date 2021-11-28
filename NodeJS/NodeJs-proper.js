var _ = require("lodash");

console.log("Testing: forEach");
{
    function Msg (text, id){
        this.text = text;
        this.id = id;
        this.reply = () => {
            console.log(text);
        }
    }
    let test = [];
    for (let i=0; i<=5; i++){
        //Вводим объект в массив
        test[i] = new Msg("msg"+(i+1), i+1);
        console.log(`Received item #${i+1}`);

        _.forEach(test[i], function(value, key) {
            console.log(`${key}: ${value}`);
        })
    }
    console.log("////////////////////////////////////////////////////"+"\n");
}