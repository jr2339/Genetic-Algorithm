//JavaScript-C24.2.0 (SpiderMonkey)

var POP_SIZE = 100; //we generate 20 solutions
var GENERATIONS = 50;

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

//random_population([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]);


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


function valid(solution1,solution2){
    var L1=[];
    var R1=[];
    var L2=[];
    var R2=[];
    var pos = solution1.length/2;
    for(var i=0; i<2*pos;i++){
        if(i < pos){
            L1.push(solution1[i][0]);
            L1.push(solution1[i][1]);
            L2.push(solution2[i][0]);
            L2.push(solution2[i][1]);           
        }
        else{
            R1.push(solution1[i][0]);
            R1.push(solution1[i][1]);
            R2.push(solution2[i][0]);
            R2.push(solution2[i][1]);            
        }
    }

    var found = false;
    for(var i=0; i< R2.length; i++){
        if(R1.indexOf(R2[i])>-1){
                found = true;
                break;
        }
    }
    
   for(var i=0; i< L1.length; i++){
        if(L2.indexOf(L1[i])>-1){
            found = true;
            break;
        }
   }
    return found;
}

//print(valid([[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]],[[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]]))

function crossover(solution1,solution2){
    var sch1=[];
    var sch2=[];
    var pos = solution1.length/2;
    sch1 = (solution2.slice(pos)).concat(solution1.slice(pos));
    sch2 = (solution2.slice(0,pos)).concat(solution1.slice(0,pos));
    return [sch1,sch2];
}

//crossover([[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]],[[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]]);

function GA(SE){
    var population = random_population(SE);
    var best_solution =[];
    for(var generation=0;generation<GENERATIONS;generation++){
        print("========================generation: " + generation + "================================");
        var weighted_population = [];
        for(var i=0; i<population.length;i++){
            var fitness_val = fitness(population[i]);
            if(fitness_val <= 20){
                var pair =[population[i],1];
            }
            else{
                var pair = [population[i],1/fitness_val];
            }    
            weighted_population.push(pair);
        }
        var population_size = weighted_population.length
        var population =[];
        for(var i=0; i<population_size/2;i++){
            var solution1 = weighted_choice(weighted_population);
            print("solution1 is: " + solution1 + " fitness value " + fitness(solution1));
            var solution2 = weighted_choice(weighted_population);
            print("solution2 is: " + solution2 + " fitness value " + fitness(solution2));
            var sch1,ch2;
            var found = valid(solution1,solution2);
            if(found == false){
                [sch1,sch2] = crossover(solution1, solution2);
                print("sch1 is: " + sch1);
                print("sch2 is: " + sch2);
                population.push(solution1);
                population.push(solution2);
                population.push(mutate(sch1));
                population.push(mutate(sch2));
            }
            else{
                print("********************no child***********************")
                population.push((solution1));
                population.push(solution2);
            }

        }
  
        var fittest_solution = population[0];
        var minimum_fitness = fitness(population[0]);
        for(var i=0; i<population.length;i++){
            var solution_fitness = fitness(population[i]);
            if(solution_fitness <= minimum_fitness){
                fittest_solution = population[i];
                minimum_fitness =solution_fitness;
            }
        }   
        print("Fittest value in Generation:" + generation + " is: " + minimum_fitness);
        print("the best solution is: "+fittest_solution);
    }
    return 0;
    
}   


GA([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20])


                  