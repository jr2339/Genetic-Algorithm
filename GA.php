var POP_SIZE = 100;
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
//print("==========================");
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
        //print(solution);
        population.push(solution);
    }
    /*
    for(var i=0; i<population.length;i++){
        print(population[i]);
    }
    */
    return population;
}
//print("========================");
//init_populations(object);


function fitness(solution){
    //print("solution is: " + solution); 
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
    var mutation_chance = 100;
    var determination = Math.floor(Math.random()*mutation_chance);
    if(determination == 10){
        print("*******************************Mutate****************");
         var m = Math.floor(Math.random() * (solution.length));
         //print(m);
         var n = Math.floor(Math.random() * (solution.length));
         //print(n);
         while(m==n){
             m = Math.floor(Math.random() * (solution.length-1));
             n = Math.floor(Math.random() * (solution.length-1));
         }
        var temp = solution[n];
        //print(temp);
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

//var s1 =[["D",4],["M",13],["F",6],["E",5],["N",14],["R",18],["J",10],["Q",17],["T",20],["H",8],["P",16],["K",11],["B",2],["L",12],["C",3],["I",9],["S",19],["O",15],["A",1],["G",7]];
//var s2 =[["Q",17],["S",19],["F",6],["R",18],["D",4],["T",20],["L",12],["O",15],["I",9],["B",2],["G",7],["K",11],["M",13],["C",3],["H",8],["A",1],["N",14],["P",16],["E",5],["J",10]];


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


//print(arraysEqual(s1,s2))



function position(solution1,solution2){
    var arr1=[];
    var arr2=[];
    [arr1,arr2] = convert(solution1,solution2);
    
    var size = arr1.length;
    var temp1 = arr1;
    //print(arr1);
    var temp2 = arr2;
    //print(arr2);
    var pos = 0;
    for(pos = size-2; pos>=2; pos-=2){
        temp1 = arr1.slice(0,pos);
        temp2 = arr2.slice(0,pos);
        var check = arraysEqual(temp1,temp2);
        if(check == true){
            break;
        }
        else{
            continue;
        }
    }    
    
     return pos;
}

var s3 =[["D",4],["F",6],["E",5],["N",14],["R",18],["J",10],["Q",17],["T",20],["H",8],["P",16],["K",11],["B",2],["L",12],["C",3],["I",9],["S",19],["O",15],["A",1],["G",7],["M",13]];
var s4 =[["N",14],["R",18],["J",10],["D",4],["E",5],["F",6],["Q",17],["S",19],["O",15],["A",1],["G",7],["B",2],["L",12],["C",3],["I",9],["T",20],["H",8],["P",16],["K",11],["M",13]];
//print(position(s3,s4))


function crossover(solution1,solution2){
    
    var pos = position(solution1,solution2);
    print("the position is: " + pos);
    
    var ch1 = (solution1.slice(0,pos)).concat(solution2.slice(pos));
    var ch2 = (solution1.slice(pos)).concat(solution2.slice(0,pos));

    
    //print("solution1 is: " + solution1);
    //print("ch1 is :      " + ch1);
    /*
    for(var i=0; i<ch1.length;i++){
        print(ch1[i]);
    }
    */
    //print("solution2 is: " + solution2);
    //print("ch2 is :      " + ch2);
    /*
    for(var i=0; i<ch1.length;i++){
        print(ch2[i]);
    }
    */
    return [ch1,ch2]; 

}

//crossover(s3,s4)


function shuffle(array){
    var temp = [];
    for(var i= array.length-1; i>0; i--){
        var j = Math.floor(Math.random() * (i + 1));
        [array[i],array[j]] = [array[j],array[i]];
    }
    return array;
}




function GA(SE,Name){
    
    var object = combine(SE,Name);
    var population = init_populations(object);
    /*
    for(var i=0; i<population.length; i++){
          print(population[i]);
    }
    */
    
    for(var generation=0;generation<GENERATIONS;generation++){
        print("========================generation: " + generation + "================================");
        var size = population.length;
        //================================Find the best solution in current population=======================
        var fittest_solution = population[0];
        var minimum_fitness = fitness(population[0]);
        for(var i=0; i<size;i++){
            var solution_fitness = fitness(population[i]);
            if(solution_fitness <= minimum_fitness){
                fittest_solution = population[i];
                minimum_fitness =solution_fitness;
            }
         }       
        
    print("Fittest value in Generation:" + generation + " is: " + minimum_fitness);
    //=============================================Generation New Population================================
    
   //print("=================================================================================================");
    population = shuffle(population);
    /*
    for(var i=0; i<size; i++){
         print("solution " + i + " is: " + population[i]);  
    }
    */
    print("\n"); 
    var temp =[];
        for(var i=0; i<size; i++){
            var solution1 = population[i];
            print("solution1 " + i + " is: " +solution1 + " fitness value is " + fitness(solution1));
            var solution2 = population[i+=1];
            print("solution2 " + i + " is: " +solution2 + " fitness value is " + fitness(solution2));
            var pos = position(solution1,solution2);
            
            if(pos>0){
                var ch1,ch2;
                [ch1,ch2] = crossover(solution1,solution2);
                print("child 1 is : " + ch1 + " fitness value is " + fitness(ch1));
                print("child 2 is : " + ch2 + " fitness value is " + fitness(ch2));
                print("------------------------------------------------");
                temp.push(solution1);
                temp.push(solution2);
                temp.push(mutate(ch1));
                temp.push(mutate(ch2));
            }
            else{
                print("No child");
                print("------------------------------------------------");
                temp.push(solution1);
                temp.push(solution2);
            }
        }
        population = temp;
        
        
    }
    
    
}






GA(SE,Name)













