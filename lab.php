//JavaScript-C24.2.0 (SpiderMonkey)

var POP_SIZE = 20; //we generate 20 solutions
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
            while( m==n){
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
    /*
    var s1 =[];
    var s2 =[];
    for(var i=0; i<pos;i++){
        s1.push(solution1[i][0]);
        s1.push(solution1[i][1]);
    }
    for(var i=0;i<solution2.length-pos;i++){
        s2.push(solution2[i][0]);
        s2.push(solution2[i][1]);
    }
    
    var found = false;
    for(var i=0;i<2*pos;i++){
        if(s2.indexOf(s1[i])>-1){
            found = true;
            break;
        }
    }
    */
    var L1=[];
    var R1=[];
    var L2=[];
    var R2=[];
    for(var i=0; i<solution1.length;i++){
        if(i <pos){
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
    for(var i=0;i<2*pos;i++){
        if(s2.indexOf(s1[i])>-1){
            found = true;
            break;
        }
    }
    
    return found;
}

//print(valid([[1,2],[3,4],[5,6],[7,8],[9,10],[11,12],[13,14],[15,16],[17,18],[19,20]],[[11,12],[13,14],[15,16],[17,18],[19,20],[1,2],[3,4],[5,6],[7,8],[9,10]],3))

function crossover(solution1,solution2, pos){
    var sch1=[];
    var sch2=[];
    sch1 = (solution2.slice(solution2.length-pos)).concat(solution1.slice(pos));
    sch2 = (solution2.slice(0,solution2.length-pos)).concat(solution1.slice(0,pos));
    print(sch1);
    print(sch2);
    return [sch1,sch2];
}

crossover([[1,2],[3,4],[5,6],[7,8],[9,10],[11,12],[13,14],[15,16],[17,18],[19,20]],[[11,12],[13,14],[15,16],[17,18],[19,20],[1,2],[3,4],[5,6],[7,8],[9,10]],3);

function GA(SE){

    var population = random_population(SE);
    for(var generation=0;generation<GENERATIONS;generation++){
        var weighted_population = [];
        for(var i=0; i<population.length;i++){
            var fitness_val = fitness(population[i]);
            if(fitness_val == 0){
                var pair =[population[i],1];
            }
            else{
                var pair = [population[i],1/fitness_val];
            }    
            weighted_population.push(pair);
        }
        var population =[];
        for(var i=0; i<weighted_population.length/2;i++){
            var solution1 = weighted_choice(weighted_population);
            var solution2 = weighted_choice(weighted_population);
            var sch1,ch2;
            //var pos = Math.floor(Math.random() * (solution1.length-1));
            var pos = 5;
            var found = valid(solution1,solution2,pos);
            if(found == false){
                [sch1,sch2] = crossover(solution1, solution2,pos);
                //population.push(solution1);
                //population.push(solution2);
                population.push(mutate(sch1));
                population.push(mutate(sch2));
            }
            else{
                population.push(solution1);
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
    }
    return 0;
    
}   


//GA([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20])


                  