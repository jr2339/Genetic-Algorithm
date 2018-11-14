//JavaScript-C24.2.0 (SpiderMonkey)

var POP_SIZE = 20; //we generate 20 solutions
var GENERATIONS = 20;

function weighted_choice(items){
  var weight_total = 0;
    for(var i = 0; i < items.length;i++){
      weight_total  =  weight_total  + items[i][1];
  }
  n = Math.random() * weight_total;
    for(var i=0; i <items.length;i++){
      if(n < items[i][1]){
          return items[i][0];
      }
      n = n - items[i][1];
    }
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


function convert(solution1,solution2){
    var array1=[];
    var array2=[];
    for(var i=0; i<solution1.length;i++){
        array1.push(solution1[i][0]);
        array1.push(solution1[i][1]);
    }
    for(var i=0; i<solution2.length;i++){
        array2.push(solution2[i][0]);
        array2.push(solution2[i][1]);
    }
    return [array1,array2];
}



function pos(solution1,solution2){
    var array1=[];
    var array2=[];
    var position = 0;
    [array1,array2] = convert(solution1,solution2);
    var temp1 = array1;
    var temp2 = array2;

    for(position = array1.length-4;position>=2;position-=2){
        var temp1 = array1.slice(0,position);
        var temp2 = array2.slice(0,position);  
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


function valid(solution1,solution2){
    var child = false;
    var probe1 = arraysEqual(solution1[solution1.length-1],solution2[solution2.length-1]);
    var probe2 = arraysEqual(solution1[0],solution2[0]);
    var position =  pos(solution1,solution2);
    if(position !=0){
        child = true;
    }
    return child;
}


function random_population(SE){
    var population =[];
    for(var i=0; i<POP_SIZE;i++){
       var index = [];
       var solution = [];
       for(var j=0; j<SE.length; j++){
            var randomnumber = Math.floor(Math.random()*SE.length);
            while(index.indexOf(randomnumber) > -1){
                randomnumber = Math.floor(Math.random()*SE.length);
            }
            index[j] = randomnumber;
        }
       
        if(SE.length %2 ==0){
            for(var j=0; j<SE.length;j=j+2){
                    solution.push([SE[index[j]],SE[index[j+1]]]);

            }                   
       }
       population.push(solution);
    }
    return population;
}    




function fitness(solution){
    var fitness=0;
    if(solution.length > 0){
        for(var i=0; i<solution.length;i++){
            fitness = fitness + Math.abs(solution[i][0]-solution[i][1]);
        }
    }
    return fitness;
}   


function mutate(solution){
   
    var mutation_chance = 10;
    var determination;
    for(var i=0; i<solution.length; i++){
        determination = Math.floor(Math.random()*mutation_chance);
        if(determination == 1){
            var m = Math.floor(Math.random() * (solution.length-1));
            var n = Math.floor(Math.random() * (solution.length-1));
            while(m==n){
                    m = Math.floor(Math.random() * (solution.length-1));
                    n = Math.floor(Math.random() * (solution.length-1));
           }
           var temp = solution[m][1]
           solution[m][1] = solution[n][1];
           solution[n][1]= temp; 
            
        }
    }  

   return solution;
}

function crossover(solution1,solution2){
   var ch1 = [];
   var ch2 = [];
   var index1 = [];
   var index2 = [];
   var array1=[];
   var array2=[];
   [array1,array2] = convert(solution1,solution2);
   var size = array1.length;
   var position =  pos(solution1,solution2);
   for(var i=0; i<position; i++){
        var rand1 = Math.floor(Math.random()*position);
        while(index1.indexOf(rand1) > -1){
           rand1 = Math.floor(Math.random()*position);
       }
       index1[i] = rand1;
       var rand2 = Math.floor(Math.random()*position);
       while(index2.indexOf(rand2) > -1){
           rand2 = Math.floor(Math.random()*position);
       }
      index2[i] = rand2;       
   }
   
   for(var i=position; i<size; i++){
       var rand1 = Math.floor(Math.random()*(size-position) + position);
         while(index1.indexOf(rand1) > -1){
           rand1 = Math.floor(Math.random()*(size-position) + position);
       }
       index1[i] = rand1;
       var rand2 = Math.floor(Math.random()*(size-position) + position);
       while(index2.indexOf(rand2) > -1){
           rand2 = Math.floor(Math.random()*(size-position) + position);
       }
       index2[i] = rand2;
   }

    for(var i=0; i<size; i+=2){
    
        ch1.push([array1[index1[i]],array1[index1[i+1]]]);
        ch2.push([array2[index2[i]],array2[index2[i+1]]]);
    }

    return [ch1,ch2];
    
}


function GA(SE){
    var population = random_population(SE);
    var best_solution =[];
    for(var generation=0;generation<GENERATIONS;generation++){
        //print("========================generation: " + generation + "================================");
        var weighted_population = [];
        var size = population.length;
        for(var i=0; i<size;i++){
            var fitness_val = fitness(population[i]);
            if(fitness_val <= 32){
                var pair =[population[i],1];
            }
            else{
                var pair = [population[i],1/fitness_val];
            }    
            weighted_population.push(pair);
        }

        var population =[];
        for(var i=0; i<size;i++){
            var solution1 = weighted_choice(weighted_population);
            var solution2 = weighted_choice(weighted_population);
            //print("==================solution 1 is=========================" + solution1);
            //print("==================solution 2 is=========================" + solution2);
            var sch1,ch2;
            var found = valid(solution1,solution2);
            if(found == true){
                [sch1,sch2] = crossover(solution1, solution2);
                //print("sch1 is: " + sch1 + " fitness value " + fitness(sch1));
                //print("sch2 is: " + sch2 + " fitness value " + fitness(sch2));
                //print("&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&");
                population.push(solution1);
                population.push(solution2);
                population.push(sch1);
                population.push(sch2);
            }
            else{
                //print("********************no child***********************")
                population.push((solution1));
                population.push(solution2);
            }

        }
  
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
       
    }
    return 0;
    
}   


GA([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20])


                  



