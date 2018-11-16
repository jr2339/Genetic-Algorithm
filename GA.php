var POP_SIZE = 10;
var GENERATIONS = 20;

function combine(SE,Name) {
    var object =[];
    for(var i=0; i<SE.length;i++){
        object.push([Name[i],SE[i]]);
    }
    /*
    for(var i=0; i<object.length; i++){
          print(object[i]);
    }
    */
    return object;
}


var SE   = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
var Name = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T"]

var object = combine(SE,Name);
print("==========================");
//print(object);

function random_index(object){
    var index =[];
    var size = object.length
    for(var i =0; i<size; i++){
        var randomnumber = Math.floor(Math.random()*size);
        while(index.indexOf(randomnumber) > -1){
            randomnumber = Math.floor(Math.random()*SE.length);
        }
        index[i] = randomnumber;
    }   
    return index;
} 



function init_populations(object){
    var population = [];
    var size = object.length;
    for(var i =0; i<POP_SIZE; i++){
        var solution =[];
        var index = random_index(object);
        for(var j=0; j<size; j++){
            solution.push(object[index[j]]);
        }
        print(solution);
        population.push(solution);
    }
    
    for(var i=0; i<population.length;i++){
        print(population[i]);
    }
    
    return population;
}
print("========================");
var p = init_populations(object);


function fitness(solution){
    print("solution is: " + solution); 
    var fitness = 0;
    for(var i=0; i<solution.length; i++){
        fitness = fitness + Math.abs(solution[i][1]-solution[i+=1][1]); 
    }
    return fitness;
}  
//print("=========================");
//print(fitness([["T",20],["G",7],["M",13],["P",16],["J",10],["A",1],["C",3],["D",4],["S",19],["H",8],["K",11],["F",6],["R",18],["O",15],["N",14],["E",5],["Q",17],["I",9],["B",2],["L",12]]));

//print([["T",20],["G",7],["M",13],["P",16],["J",10],["A",1],["C",3],["D",4],["S",19],["H",8],["K",11],["F",6],["R",18],["O",15],["N",14],["E",5],["Q",17],["I",9],["B",2],["L",12]]);

function mutate(solution){
    var mutation_chance = 10;
    var determination = Math.floor(Math.random()*mutation_chance);
    if(determination == 1){
         var m = Math.floor(Math.random() * (solution.length));
         print(m);
         var n = Math.floor(Math.random() * (solution.length));
         print(n);
         while(m==n){
             m = Math.floor(Math.random() * (solution.length-1));
             n = Math.floor(Math.random() * (solution.length-1));
         }
        var temp = solution[n];
        print(temp);
        solution[n] = solution[m];
        solution[m] = temp;
    }  
    
    return solution; 
    
    
}    

//print(mutate([["T",20],["G",7],["M",13],["P",16],["J",10],["A",1],["C",3],["D",4],["S",19],["H",8],["K",11],["F",6],["R",18],["O",15],["N",14],["E",5],["Q",17],["I",9],["B",2],["L",12]]));

function convert(solution1,solution2){
    var arr1 = [];
    var arr2 = [];
    var size1 = solution1.length;
    
    for(var i=0; i<size1; i++){
        arr1.push(solution1[i][1]);
        arr2.push(solution2[i][1]);
    }
    return [arr1,arr2];
}   

var s1 =[["D",4],["M",13],["F",6],["E",5],["N",14],["R",18],["J",10],["Q",17],["T",20],["H",8],["P",16],["K",11],["B",2],["L",12],["C",3],["I",9],["S",19],["O,15],["A",1],["G",7]];
var s2 =[["Q",17],["S",19],["F",6],["R",18],["D",4],["T",20],["L",12],["O",15],["I",9],["B",2],["G",7],["K",11],["M",13],["C",3],["H",8],["A",1],["N",14],["P",16],["E",5],["J",10]];


function arraysEqual(solution1,solution2){
    var arr1=[];
    var arr2=[];
    [arr1,arr2] = convert(solution1,solution2);
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






function position(soulution1,solution2){

    
    
    
    

}

