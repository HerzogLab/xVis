function Node(name){
	this.name = name;
	this.child1;
	this.child2;
}

function Sort(proteinNames,connections,names){
	var returnTypes = {"LIST":"L","ARRAY":"A"};
	
	this.proteinNames=proteinNames;
	this.connections=connections;
	this.names=names;
	
	var compare =function(a, b) {
		if (names[a] < names[b])
			return -1;
		if (names[a] > names[b])
			return 1;
		return 0;
	}
	
	this.alphabeticalSort =function(returnType){
		switch (returnType){
			case returnTypes.LIST:
				return ((names[proteinNames[0]]==null) ? this.proteinNames.sort() : this.proteinNames.sort(compare));
			case returnTypes.ARRAY:
				return [((names[proteinNames[0]]==null) ? this.proteinNames.sort() : this.proteinNames.sort(compare))];
				break;
		}
	}
	
	this.createAdjacencyList =function(){
		var vectors = []
		for (var i = 0 ; i < proteinNames.length ; i++) {
			for (var j = 0 ; j < proteinNames.length ; j++) {
				if(connections[[proteinNames[i],proteinNames[j]].sort()]){
					if(vectors[proteinNames[i]]==null)
						vectors[proteinNames[i]]=[];
					vectors[proteinNames[i]].push(proteinNames[j]);
					if(vectors[proteinNames[j]]==null)
						vectors[proteinNames[j]]=[];
					vectors[proteinNames[j]].push(proteinNames[i]);
				}
			}
		}
		return vectors;
	}
	
	this.unconnectedSubgraphsAlphabetically =function(returnType){
		var result=[];
		this.unconnectedSubgraphs().forEach(function(array){
			array =((names[array[0]]==null) ? array.sort() : array.sort(compare));
			switch (returnType){
				case returnTypes.LIST:
					result =result.concat(array);
					break;
				case returnTypes.ARRAY:
					result.push(array);
					break;
			}
		});
		return result;
	}
	
	this.unconnectedSubgraphsHierarchical = function(returnType){
		var result = [];
		this.unconnectedSubgraphs().forEach(function(array){
			switch (returnType){
				case returnTypes.LIST:
					result =result.concat(hierarchicalClustering(array));
					break;
				case returnTypes.ARRAY:
					result.push(hierarchicalClustering(array));
					break;
			}
		});
		return result;
	}
	
	var hierarchicalClustering =function(array){
		var m =[],
			nodeList =[];
		
		for(var i=0;i<array.length;++i){
			nodeList.push(new Node(array[i]));
			m[i]=[];
			for(var j=0;j<array.length;++j){
				var con = connections[[array[i],array[j]].sort()];
				m[i][j] = con==null? 0 : con;
				m[i][j] = con==null? 0 : con;
			}
		}
		
		while(m.length>1){ 
			var max=0,
				cords=[0,0];
			
			for(i=0;i<m.length;++i){
				for(j=0;j<m[i].length;++j){
					if(m[i][j]>max && i!=j){
						max=m[i][j];
						cords=[i,j];
					}
				}
			}
			
			var n = new Node();
			
			n.child1=nodeList[cords[0]];
			n.child2=nodeList[cords[1]];
			nodeList[cords[0]]=n;
			nodeList.splice(cords[1], 1);
			
			for(var k=0;k<m.length;++k){
				m[k][cords[0]] = (m[k][cords[0]] + m[k][cords[1]])/2;
				m[cords[0]][k] = (m[cords[0]][k] + m[cords[1]][k])/2;
			}
			
			for(var k=0;k<m.length;++k){
				m[k].splice(cords[1], 1);
			}
			
			m.splice(cords[1], 1);	
		}
		return resursiveDFS(nodeList[0]);
	}
	
	var resursiveDFS = function(node){
		var list = [];
		
		if(node.child1 != null){
			list = resursiveDFS(node.child1);
		}
		if(node.child2 != null){
			list =sortNodes(list, resursiveDFS(node.child2));
		}
		if(node.name != null){
			list.push(node.name);
		}
		return list;
	}
	
	var sortNodes = function(list, rec){ 
		if(list.length == 0){
			return rec;
		}
		var dists = [dist(list[0], rec[0]),
				dist(list[list.length-1], rec[rec.length-1]),
				dist(list[list.length-1], rec[0]),
				dist(list[0], rec[rec.length-1])];
		var min1 = (dists[0] > dists[1] ? 0 : 1),
			min2 = (dists[2] > dists[3] ? 2 :3);

		switch(dists[min1] > dists[min2] ? min1 : min2){
			case 0:
				return list.reverse().concat(rec);
			case 1:
				return list.concat(rec.reverse());
			case 2:
				return list.concat(rec);
			case 3:
				return rec.concat(list);
		}
	}
	
	var dist = function(name1, name2){
		var con = this.connections[[name1, name2].sort()];
		
		return con == null ? 0 : con;
	}
	
	var mcl = function(array,inflation, expansion){
		var vectors = [];
		
		for (var i = 0 ; i < array.length ; i++) {
			vectors[i]=[];
				for (var j = 0 ; j < array.length ; j++) {
					var con = connections[[array[i],array[j]].sort()];
					if(i==j)
						con = 0;
					vectors[i][j]=con == null ? 0 :con;
				}
		}
		
		for (var i = 0 ; i < array.length ; i++) {
			var sum =0;
			for (var j = 0 ; j < array.length ; j++) {
				sum += vectors[i][j];
			}
			vectors[i][i] = sum;
		}

		var c = new MarkovCluster();
		
		c.setMatrix(vectors);
		c.cluster(inflation, expansion);		
		return c.getCluster();
	}

	var convertNodesToArray = function(nodes, names){
			list = [];
			for(var i=0; i<nodes.length;++i){
				if(list[nodes[i].group] == null){
					list[nodes[i].group] = [];
				}
				list[nodes[i].group].push(names[i]);
				
			}
		return list;
	}
	
	this.unconnectedSubgraphsMCL = function(returnType, param){
		var result = [],
		expansion = param[0],
		inflation = param[1],
		minSize = param[2];
		this.unconnectedSubgraphs().forEach(function(array){
			mcl(array, inflation, expansion);
			if(array.length > minSize){
				convertNodesToArray(mcl(array, inflation ,expansion), array).forEach( function(arr){
					switch (returnType){
						case returnTypes.LIST:
							result = result.concat(arr);
							break;
						case returnTypes.ARRAY:
							result.push(arr);
							break;
					}
				});
			}else{
				switch (returnType){
					case returnTypes.LIST:
						result =result.concat(array);
						break;
					case returnTypes.ARRAY:
						result.push(array);
						break;
				}
			}
		});
		return result;
	}
	
	this.unconnectedSubgraphs =function(){
		var list = this.createAdjacencyList(),
			garaph,
			names = this.proteinNames,
			visited = [],
			result = [],
			subgraph = [],
			i = 0,
			notReady = true;
			
		subgraph.push(names[0]);
		
		while (notReady){
			result[i]=[];
			for (var j = 0;j < subgraph.length;j++){
				if(visited[subgraph[j]] == null){
					result[i].push(subgraph[j]);
					visited[subgraph[j]] = subgraph[j];
				}
				list[subgraph[j]].forEach(function(element){
					if(visited[element] == null){
						subgraph.push(element);
					}
				});
			}
			
			++i;
			for (j = names.length - 1;j >= 0;j--){
				if(!visited[names[j]]){
					delete subgraph;
					subgraph = [];
					subgraph.push(names[j]);
					break;
				}
				if(j==0){
					notReady = false;
				}
			}
		}
		return result;
	}
	
	this.sort =function(sortType, returnType, param){
		switch(sortType){
			case "alphabetical": 
				return this.alphabeticalSort(returnType);
				break;
			case "unconnectedSubgraphsAlphabetical":
				return this.unconnectedSubgraphsAlphabetically(returnType);
				break;
			case "unconnectedSubgraphsMCL":
				return this.unconnectedSubgraphsMCL(returnType, param);
				break;
			case "unconnectedSubgraphsHierarchical":
				return this.unconnectedSubgraphsHierarchical(returnType);
				break;
			case "none":
				return returnType == returnTypes.LIST ? this.proteinNames :[this.proteinNames];
		}
			

	}
}
function MarkovCluster(){
	this.matrix = [];

	this.print =function(m){
		var matrix ="";
		
		for(var i = 0; i < m.length; i++){
			for(var j = 0; j< m.length; j++){
			matrix += m[i][j] + " & ";
			}
			matrix += " \\\\\n";
		} 
		
		var p = document.createElement('p');
		p.innerHTML = matrix
		document.body.appendChild(p);
	}

	this.setMatrix = function(matrix){
		this.matrix=matrix;
	}
	
	this.cluster = function(inflation, expansion){
		var previousMatrix = this.new2dArray(this.matrix.length),
			currentMatrix = this.normalize(this.matrix), 
			counter = 0;
			
		while(counter++<800 &&! this.equals(previousMatrix, currentMatrix)){
			previousMatrix = currentMatrix;
			currentMatrix = this.normalize(this.inflate(this.expand(currentMatrix, expansion), inflation));
		}
		this.matrix = currentMatrix;
		return currentMatrix;
	}

	this.expand = function(matrix, expansion){
		for( ;expansion > 0; expansion--){
			var n = matrix.length,
				result = [];
			for( var row=0; row < n; row++){
				result[row] = [];
				for( var col = 0; col < n; col++){
					result[row][col] = 0;
					for( var i = 0; i < n; i++){
						result[row][col] += matrix[i][col] * matrix[row][i];
					}
				}
			}
			matrix = result;
		}
		return result;	
	}
	
	this.equals = function(matrix1,matrix2){
		var n = matrix1.length;
		
		for(var row = 0; row < n; row++){
			for( var col = 0; col < n; col++){
				if(matrix1[row][col] != matrix2[row][col]){
					return false;
				}
			}
		}
		return true;
	}
	
	this.inflate = function(matrix, inflation){
		var n = matrix.length;
		
		for( var row = 0; row < n; row++){
			for( var col = 0; col < n; col++){
				matrix[row][col] = Math.pow(matrix[row][col], inflation);
			}
		}
		return matrix;
	}
	
	this.new2dArray = function(n){
		var array = [],
			row = [];
			
		for( var i=0; i < n; i++){
			row.push(0);
		}
		for( var i=0; i < n; i++){
			array.push(row);
		}
		return array;
	}
	this.normalize = function(matrix){
		var n = matrix.length,
			sum;

		for(var row = 0; row < n; row++){
			sum = 0;

			for(var col = 0; col < n; col++){
				sum += matrix[row][col];
			}

			for(var col=0; col < n; col++){
				matrix[row][col] /= sum;
			}
		}
		return matrix;
	}
	
	this.getCluster = function(){
		var n = this.matrix.length,
			group = 1, 
			sum = 0,
			list = [];
			
		for( var i=0; i < n; i++){
			list[i] = {"group" : 0, "value" : 0};
		}
		
		for( var col = 0; col < n; col++){
			for( var row = 0; row < n; row++){
				if(this.matrix[row][col] > 0 && this.matrix[row][col] > list[row].value){
					list[row].value = this.matrix[row][col];
					list[row].group = group;
					sum += this.matrix[row][col];
				}
			}
			if(sum > 0.1){
				group++;
				sum = 0;
			}
		}
		return list;
	}
}