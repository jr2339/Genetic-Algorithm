var POP_SIZE = 20;
var GENERATIONS = 20;

function random_index(SE){
    var index =[];
    var size = SE.length
    for(var i =0; i<size; i++){
        var randomnumber = Math.floor(Math.random()*size);
        while(index.indexOf(randomnumber) > -1){
            randomnumber = Math.floor(Math.random()*SE.length);
        }
        index[i] = randomnumber;
    }   
    return index;
}    


function init_populations(SE){
    var population = [];
    var size = SE.length;
    for(var i =0; i<POP_SIZE; i++){
        var solution =[];
        var index = random_index(SE);
        for(var j=0; j<size; j+=2){
            solution.push([SE[index[j]],SE[index[j+1]]]);
        }
        population.push(solution);
    }
    
    for(var i=0;i<POP_SIZE;i++){
        print(population[i]);
    }
    
    
    return population;
}

//init_populations([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20])


function fitness(solution){
    var fitness = 0;
    for(var i=0; i<solution.length; i++){
        fitness = fitness + Math.abs(solution[i][0]-solution[i][1]); 
    }
    return fitness;
}    


/*
function mutate(solution){
    //need to modify
}    
*/



//=======================Corssover=============================

function arraysEqual(arr1, arr2) {
    if(arr1.length !== arr2.length){
        return false;
    }
    arr1.sort();
    arr2.sort();
    for(var i = arr1.length; i--;) {
        if(arr1[i] !== arr2[i])
            return false;
    }

    return true;
}


function position(arr1,arr2){
     var size = arr1.length;
     var temp1 = arr1;
     var temp2 = arr2;
     var position = 0;
     for(position = size-2; position >=2; position-=2){
        temp1 = arr1.slice(0,position);
        temp2 = arr2.slice(0,position);
        var check = arraysEqual(temp1,temp2);
        if(check == true){
            break;
        }
         else{
             continue;
         }     
     }
    
     return position;

}




function valid(arr1,arr2){
    var child = false;
    var pos =  position(arr1,arr2);
    if(pos > 0){
        child = true;
    }
    return child;
}


function crossover(solution1,solution2){
    
    //var ch1=[];
    //var ch2 =[];
    var arr1 = [];
    var arr2 = [];
    var size1 = solution1.length;
    
    for(var i=0; i<size1; i++){
        arr1.push(solution1[i][0]);
        arr1.push(solution1[i][1]);
        arr2.push(solution2[i][0]);
        arr2.push(solution2[i][1]);
    }
    
    var index1 = [];
    var index2 = [];
    var pos =  position(arr1,arr2);
    print("pos is " + pos/2);
    
    var ch1 = (solution1.slice(0,pos/2)).concat(solution2.slice(pos/2));
    var ch2 = (solution1.slice(pos/2)).concat(solution2.slice(0,pos/2));
 
   print("solution1 is: " + arr1);
   print("ch1 is :      " + ch1);
   print("solution2 is: " + arr2);
   print("ch2 is :      " + ch2);
   return [ch1,ch2]; 
    
}    

var s1= [[16,17],[9,7],[13,5],[12,8],[10,6],[18,3],[19,14],[2,4],[11,20],[15,1]]
var s2= [[17,5],[16,7],[13,9],[12,1],[8,6],[18,20],[3,4],[15,14],[11,19],[2,10]]

var ch1, ch2;
[ch1,ch2] = crossover(s1,s2)





print(position(ch1,ch2))


















