stringToDate = function(string){
    var array_data = string.split('-');
    var data = new Date(array_data[0], array_data[1]-1, array_data[2]);
    return data;
};
