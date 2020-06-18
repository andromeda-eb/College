% Two Jugs, 7L and 4L. Goal is 5L

% Section 1: Actions (If invalid node, return [0,0])
%--------------------------------------------------
% Step 1:  Fill 7L jug
action1([X,Y],Open,Closed,Z):-
	( not_in_lists([7,Y],Open,Closed) ) ->
	Z = [7,Y];
	Z = [0,0].

% Step 2: Fill 4L jug
action2([X,Y],Open,Closed,Z) :-
	( not_in_lists([X,4],Open,Closed) ) ->
	Z = [X,4];
	Z = [0,0].

% Step 3: Empty 7L jug into 4L
action3([X,Y],Open,Closed,Z) :- 
	Sum is X+Y, 
	( not_in_lists([0,Sum],Open,Closed), (Sum =< 4) )-> 
	Z = [0,Sum];
	Z = [0,0]. 

% Step 4: Empty 4L jug into 7L
action4([X,Y],Open,Closed,Z) :-
	Sum is X+Y,
	not_in_lists([Sum,0],Open,Closed), (Sum =< 7) -> 
	Z = [Sum,0];
	Z = [0,0].

% Step 5: Fill 4L jug from 7L jug
action5([X,Y],Open,Closed,Z) :-
	Sum is X+Y,
	Calc is Sum-7,
	not_in_lists([7,Calc],Open,Closed), (X + Y > 7) ->
	Z = [7,Calc];
	Z = [0,0].

% Step 6: Fill the 7L jug from the 4L jug
action6([X,Y],Open,Closed,Z) :-
	 Sum is X+Y,
	 Calc is X+Y-4,
	( not_in_lists([Calc,4],Open,Closed), (X + Y > 4) ) ->
	 Z = [Calc,4];
	 Z = [0,0].

% Step 7: Empty the 4L jug
action7([X,Y],Open,Closed, Z) :-
	not_in_lists([X,0],Open,Closed) ->
	Z = [X,0];
	Z = [0,0].

% Step 8: Empty the 7L jug
action8([X,Y],Open,Closed,Z) :-
	not_in_lists([0,Y],Open,Closed) ->
	Z = [0,Y];
	Z = [0,0].
%--------------------------------------------------
% Section 2: Retrieving valid nodes
%--------------------------------------------------
perform_actions(Node,Open,Closed,Valid_Nodes) :-
	action1(Node,Open,Closed,A),
	action2(Node,Open,Closed,B),
	action3(Node,Open,Closed,C),
	action4(Node,Open,Closed,D),
	action5(Node,Open,Closed,E),
	action6(Node,Open,Closed,F),
	action7(Node,Open,Closed,G),
	action8(Node,Open,Closed,H),
	Temp = [A,B,C,D,E,F,G,H],
	subtract(Temp,[[0,0]],Valid_Nodes).
%--------------------------------------------------
% Section 3: Goal (recursion)
%--------------------------------------------------

goal(Open,Closed) :-
	get_head(Open, [X,Y]),
	( X == 5; Y == 5 ) ->
	print_solution([X,Y],Closed).

goal(Open,Closed) :-
	get_head(Open, H),
	perform_actions(H,Open,Closed, Nodes),
	modify_open_and_closed(Open,Closed,Open1,Closed1,Nodes),
	( 
		if_finished(Open,Nodes,Closed1) -> 
		true;
		print_dfs(Open1,Closed1)
	),
	goal(Open1,Closed1).
%--------------------------------------------------
% Section 4: Helper Rules
%--------------------------------------------------
if_finished(Open,Nodes,Closed) :-
	length(Open,Open_Len),
	length(Nodes,Nodes_Len),
	(
		Nodes_Len == 0,
		Open_Len == 1,
		get_head(Open,H),
		write(H),
		write(" :Finished\t\t\t\t\t"),
		write(Closed)
	).

modify_open_and_closed(Open,Closed,Open2,Closed1,Nodes):-
	get_head(Open,H),
	append(Closed,[H],Closed1),
	subtract(Open,[H],Open1),
	append(Nodes,Open1,Open2).
	
not_in_lists(X,Open,Closed) :-
	not(member(X,Open)), 
	not(member(X,Closed)).

get_head([H|T], H).

print_dfs(Open,Closed) :-
	last_in_list(Closed,L),
	write(L),
	write("\t\t"),
	write(Open),
	length(Open,Len),
	loop("\t",0,3-Len),
	write("\t\t"),
	write(Closed),
	write("\n").

print_header() :-
	loop("-",0,181),
	swritef(F, '%20L%w', ["\n| Node","Open"]),
	write(F),
	swritef(S, '%30L%w', [" ","Closed"]),
	write(S),
	loop(" ",0,121),
	write("|\n"),
	loop("-",0,181),
	write("\n").

print_solution(G,Closed) :-
	write(G),
	write(" :Goal"),
	write("\t\t\t\t\t"),
	writeln(Closed).

last_in_list([X],X).

last_in_list([_|L],X) :- 
	last_in_list(L,X).

loop(C,N,S):- 
	N >= S, !.

loop(C,N,S):-
	write(C),
	N1 is N+1,
	loop(C,N1,S).
%--------------------------------------------------
% Section 5: Start rule
%--------------------------------------------------
solve :- 
	Open = [[0,0]],
	Closed = [],
	print_header(),
	write("[]\t\t"),
	write(Open),
	write("\t\t\t\t"),
	writeln(Closed),
	goal(Open,Closed).

