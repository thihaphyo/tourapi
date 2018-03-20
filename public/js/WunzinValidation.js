/**
 * @return {string}
 */
function CheckNull(valueArray,idArray){

    var arr=[];

    for (let i =0; i< valueArray.length; i++)
    {
       if(valueArray[i] == "" || valueArray[i] == 0 )
       {
            arr.push(idArray[i]);
       }else{
           arr.push('Pass');
       }
    }

    let removeItem = 'Pass';

    arr = $.grep(arr, function(value) {
        return value != removeItem;
    });

    return arr.length == 0 ? 'Pass' : arr[0];
}