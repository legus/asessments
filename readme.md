Assesments Correlation API
-
By Gustavo A Gomez

This is an API component that resumes the implementation of test applications online using PHP asa a backend programming language and web REST services with JSON as input/output parameters.

<b>Requirements:</b>
- Apache 2.4
- PHP 7+

<b>Instalation:</b>
Deploy on the public folder (htdocs) on an apache web server.

<b>Structure:</b>
Directories

- config: Database connection (uses json files to store and retrieving data)
	- database.php
- data: Data structure (json files only displayed as example)
	- asses_answer.json
	- assesments.json
	- takers.json
	- tests.json
- object: Data models objects:
	- assesments.php
	- asses_answer.php (Assesmente Answers)
	- taker.php
	- test.php
- assesment: operations for assesments
	- create.php
	- get_asssesmentquestions.php
	- get_asssesmentbytaker.php
- asses_answer
	- create.php
- taker
	- create.php
- test
	- create.php
	- get_test.php

How to use:
Access the services using http methods GET and POST in your local web server

Example 1: <b>Create test</b>
Assuming local web server responding on http://localhost/assesments/

- Method: POST
- URL: http://localhost/assesments/test/create.php
- data:<br> 
<code>
{
	{"test_id":"2","n_questions":"15",
	    "questions":{
	        "q1":{
	        	"id":"q1","text":"<b>'asdfsdf'</b>","n_options":"4","options":{
	        		"opt1":{
	        			"id":"opt1","text":"<b>option1</b>"
	        		},
	        		"opt2":{
	        			"id":"opt2","text":"option2"
	        		},
	        		"opt3":{
	        			"id":"opt3","text":"option3"
	        		},
	        		"opt4":{
	        			"id":"opt4","text":"option4"
	        		}
	        	}
	        },
	        "q2":{
	        	"id":"q2","text":"question2","n_options":"4","options":{
	        		"opt1":{
	        			"id":"opt1","text":"option1"
	        		},
	        		"opt2":{
	        			"id":"opt2","text":"option2"
	        		},
	        		"opt3":{
	        			"id":"opt3","text":"option3"
	        		},
	        		"opt4":{
	        			"id":"opt4","text":"option4"
	        		}
	        	}
	    	},
	    },
	"time":"60"
	}
}
</code>

Example 2: <b>Create Assesment</b>
- Method: POST
- URL: http://localhost/assesments/assesment/create.php
- data:<br> 
<code>
	{"first_name":"Gustavo","last_name":"Gomez","email":"guado0419@gmail.com"}
</code>

Example 3: <b>Get Assesment by taker</b>
- Method: GET
- URL: http://localhost/assesments/assesment/get_assesmentbytaker.php?taker=guado0419@gmail.com

Example 4: <b>Submit Assesment answer</b>
- Method: POST
- URL: http://localhost/assesments/asses_answer/create.php
- data: <br>
<code>
	{"session_id":"6a846640-687f-9c41-6abb-5f4c3a16eeeb","question":"q1","option_answered":"opt2"}	
</code>
