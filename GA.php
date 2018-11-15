var POP_SIZE = 30;
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


//=======================Mutation=============================

function mutate(solution){
    var mutation_chance = 100;
    var determination;
    determination = Math.floor(Math.random()*mutation_chance);
    if(determination == 1){
         var m = Math.floor(Math.random() * (solution.length));
         var n = Math.floor(Math.random() * (solution.length));
         while(m==n){
             m = Math.floor(Math.random() * (solution.length-1));
             n = Math.floor(Math.random() * (solution.length-1));
         }
        var temp = solution[m];
        solution[n] = solution[m];
        solution[m] = temp;
    }    
    return solution;
}    



//=======================Corssover=============================

function convert(solution1,solution2){
    var arr1 = [];
    var arr2 = [];
    var size1 = solution1.length;
    
    for(var i=0; i<size1; i++){
        arr1.push(solution1[i][0]);
        arr1.push(solution1[i][1]);
        arr2.push(solution2[i][0]);
        arr2.push(solution2[i][1]);
    }
    return [arr1,arr2];
}   


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

/*
function valid(arr1,arr2){
    var child = false;
    var pos =  position(arr1,arr2);
    if(pos > 0){
        child = true;
    }
    return child;
}
*/

function crossover(solution1,solution2,arr1,arr2){
    var index1 = [];
    var index2 = [];
    var pos =  position(arr1,arr2);
    print("the position is: " + pos);
    
    var ch1 = (solution1.slice(0,pos/2)).concat(solution2.slice(pos/2));
    var ch2 = (solution1.slice(pos/2)).concat(solution2.slice(0,pos/2));
    
    /*
    print("solution1 is: " + arr1);
    print("ch1 is :      " + ch1);
    for(var i=0; i<ch1.length;i++){
        print(ch1[i]);
    }
    print("solution2 is: " + arr2);
    print("ch2 is :      " + ch2);
    for(var i=0; i<ch1.length;i++){
        print(ch2[i]);
    }
    */
    return [ch1,ch2]; 
    
}    
//var arr1,arr2;

//var s1= [[16,17],[9,7],[13,5],[12,8],[10,6],[18,3],[19,14],[2,4],[11,20],[15,1]];

//var s2= [[17,5],[16,7],[13,9],[12,1],[8,6],[18,20],[3,4],[15,14],[11,19],[2,10]];

//[arr1,arr2] = convert(s1,s2);

//crossover(s1,s2,arr1,arr2);

//print(position(ch1,ch2))



function shuffle(array){
    var temp = [];
    for(var i= array.length-1; i>0; i--){
        var j = Math.floor(Math.random() * (i + 1));
        [array[i],array[j]] = [array[j],array[i]];
    }
    return array;
}


  




function GA(SE){
    var population = init_populations(SE);
    
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
        population = shuffle(population);
        
        for(var i=0; i<size; i++){
          print("solution " + i + " is: " + population[i]);  
        }
        print("\n");
        var temp = [];
        for(var i=0; i<size;i++){
            var solution1 = population[i];
            print("solution1 " + i + " is: " +solution1 + " fitness value is " + fitness(solution1));
            var solution2 = population[i+=1];
            print("solution2 " + i + " is: " +solution2 + " fitness value is " + fitness(solution2));
            var arr1 = [];
            var arr2 = [];
            [arr1,arr2] = convert(solution1,solution2);
            var pos = position(arr1,arr2);
            if(pos > 0){
                var ch1,ch2;
                [ch1,ch2] = crossover(solution1,solution2,arr1,arr2);
                
                
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


GA([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20])












