//JavaScript-C24.2.0 (SpiderMonkey)

var POP_SIZE = 20; //we generate 20 solutions
var GENERATIONS = 100;

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


function valid(solution1,solution2,pos){
    var L1=[];
    var R1=[];
    var L2=[];
    var R2=[];
    var size = solution1.length;

    L1 = solution1.slice(0,pos);
    R1 = solution1.slice(pos);
    L2 = solution2.slice(0,solution2.length-pos);
    R2 = solution2.slice(solution2.length-pos);
    
    var found = false;
    if(R2.length <= R1.length){
        for(var i=0; i< R2.length; i++){
            if(R1.indexOf(R2[i])>-1){
                found = true;
                break;
            }
        }      
    }
    
    if(R2.length > R1.length){
        for(var i=0; i< R1.length; i++){
            if(R2.indexOf(R1[i])>-1){
                found = true;
                break;
            }
        }         
    }    
    
    if(L2.length <= L1.length){
        for(var i=0; i< L2.length; i++){
            if(L1.indexOf(L2[i])>-1){
                found = true;
                break;
            }
       }
    }
    if(L2.length > L1.length){
        for(var i=0; i< L1.length; i++){
            if(L2.indexOf(L1[i])>-1){
                found = true;
                break;
            }
       }
    }    
    

    return found;
}

//print(valid([[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]],[[100,110],[113,111],[128,120],[116,115],[114,113],[124,127],[127,128],[120,126],[149,150],[243,91]],3))


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

//print(arraysEqual([1,2,3,4],[2,1,3,4]))

function pos(solution1,solution2){
    var array1=[];
    var array2=[];
    var position;
    for(var i=0; i<solution1.length;i++){
        array1.push(solution1[i][0]);
        array1.push(solution1[i][1]);
    }
    for(var i=0; i<solution2.length;i++){
        array2.push(solution2[i][0]);
        array2.push(solution2[i][1]);
    }
    var temp1 = array1;
    var temp2 = array2;
    var probe1 = arraysEqual(solution1[solution1.length-1],solution2[solution2.length-1]);
    var probe2 = arraysEqual(solution1[0],solution2[0]);
    if(probe1 == false && probe2 == false){
        for(position = array1.length-4;i>-1;position-=2){
            print("position is : " + position);
           
            var temp1 = array1.slice(0,position);
            print("temp1 is : " + temp1);
            var temp2 = array2.slice(0,position);
            print("temp2 is : " + temp2);
           
            var check = arraysEqual(temp1,temp2);
            print("check is : " + check);
            print("========================================");
            if(check == true){
                return position;
            }
            else{
                continue;
            }
           
        }
    }
    
}

var a = [[1,2],[3,4],[5,6],[7,8],[9,10],[11,12],[13,14],[15,16],[17,18],[19,20]]

var b = [[1,2],[3,4],[5,7],[8,9],[10,12],[11,20],[6,19],[13,18],[14,16],[15,17]]


print(pos(a,b))

function crossover(solution1,solution2){
   
    
   var result;

    return result;
}

var solution1 = [[1, 2], [3, 4], [5, 6], [7, 8], [10, 11], [12, 13], [14, 15], [16, 17], [18, 19]]
var solution2 = [[1, 2], [3, 4], [7, 5], [8, 6], [18, 17], [16, 15], [14, 12], [13, 11], [10, 9]]

//print(crossover(solution1,solution2))



function crossover(solution1,solution2,pos){
    var sch1=[];
    var sch2=[];
    sch1 = (solution2.slice(solution2.length-pos)).concat(solution1.slice(pos));
    //print(sch1);
    sch2 = (solution2.slice(0,solution2.length-pos)).concat(solution1.slice(0,pos));
    //print(sch2);
    return [sch1,sch2];
}

//crossover([[12,10],[13,11],[8,20],[6,5],[14,3],[4,7],[17,18],[1,16],[19,15],[2,9]],[[100,110],[113,111],[128,120],[116,115],[114,113],[124,127],[127,128],[120,126],[149,150],[243,91]],3);

function GA(SE){
    var population = random_population(SE);
    var best_solution =[];
    for(var generation=0;generation<GENERATIONS;generation++){
        //print("========================generation: " + generation + "================================");
        var weighted_population = [];
        for(var i=0; i<population.length;i++){
            var fitness_val = fitness(population[i]);
            if(fitness_val <= 32){
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
            var pos = Math.floor(Math.random() * (solution1.length-1));
            var found = valid(solution1,solution2,pos);
            if(found == false){
                [sch1,sch2] = crossover(solution1, solution2,pos);
                print("sch1 is: " + sch1 + " fitness value " + fitness(sch1));
                print("sch2 is: " + sch2 + " fitness value " + fitness(sch2));
                print("&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&");
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
        for(var i=0; i<population_size;i++){
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


                  