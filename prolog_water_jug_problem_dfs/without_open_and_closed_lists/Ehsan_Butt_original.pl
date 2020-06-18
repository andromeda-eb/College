% Two Jugs, 7L and 7L. Goal is 5L

% Section 1: Defining actions 
%--------------------------------------------------

% Step 1:  Fill 7L jug
action([X,Y],[7,Y]).% :- writeln("Step 1").

% Step 5: Fill 4L jug
action([X,Y],[X,4]). % :- writeln("Step 5").

% Step 4: Empty 7L jug into 4L
action([X,Y],[0,Z]) :- 
	(X + Y =< 4) -> Z is X + Y. %, writeln("Step 4").

% Step 7: Empty 4L jug into 7L
action([X,Y],[Z,0]) :- 
	(X + Y =< 7) -> Z is X + Y. %, writeln("Step 7").

% Step 5: Fill 7L jug from 4L jug
action([X,Y],[7,Z]) :- 
	(X + Y > 7) -> Z is (X+Y-7). %, writeln("Step 5").

% Step 6: Fill the 4L jug from the 7L jug
action([X,Y],[Z,4]) :- 
	(X + Y > 4) -> Z is (X+Y-4). %, writeln("Step 6").

% Step 7: Empty the 4L jug
action([X,Y],[X,0]). % :- writeln("Step 7").

% Step 8: Empty the 7L jug
action([X,Y],[0,Y]). % :- writeln("Step 8").
%--------------------------------------------------

% Section 2: Defining base case for goal
%--------------------------------------------------

goal([5,Y], List) :-
	print_solution([5,Y], List), !.

goal([Y,5], List) :- 
	print_solution([Y,5], List), !.

%--------------------------------------------------

% Section 3: Defining recursive call for goal
%--------------------------------------------------
goal([X,Y], List) :-
	not_in_list([X,Y],List),
	append_to_list([X,Y],List,New_List),
	action([X,Y],Z),
	goal(Z, New_List).

% Section 4: Defining helper rules
%--------------------------------------------------
append_to_list(Node,List,[Node|List]).

not_in_list(Node,List) :-
	not(member(Node,List)).

reverse([],Z,Z).

reverse([H|T],Z,Acc) :- reverse(T,Z,[H|Acc]).

print_solution(Found, List) :-
	append_to_list(Found, List, Solution),
	reverse(Solution, Reversed_Solution, []),
	writeln(Reversed_Solution).
%--------------------------------------------------

% Just type "solve" into terminal to execute the program
solve :- 
	goal([0,0], []).
