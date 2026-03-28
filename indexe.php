<?php
session_start();

// Admin authentication check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host="localhost";
$username="root";  
$password="";
$database="quize_app";
$conn=new mysqli($host,$username,$password,$database);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error );
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){

$question_text = trim($_POST['question_text']); 
$category = trim($_POST['category'] ?? 'General');
$difficulty = trim($_POST['difficulty'] ?? 'medium');
$answers= $_POST['answers'];
$correct_answers= isset( $_POST['correct'])? $_POST['correct']:[];
if(!empty($question_text) && !empty($answers)){
$stmt = $conn->prepare("INSERT INTO question (question_text, category, difficulty)
VALUES (?, ?, ?)");
$stmt->bind_param("sss",$question_text, $category, $difficulty);
$stmt->execute();
$question_id = $stmt->insert_id; 
$stmt->close();
foreach ($answers as $index => $answer_text){
if(trim($answer_text) !=""){
    $is_correct= in_array($index,$correct_answers) ? 1 : 0;

    $stmt =$conn->prepare("INSERT INTO answer (question_id,answer_text,is_correct) VALUES (?,?,?)");
    $stmt->bind_param("isi", $question_id,$answer_text,$is_correct);
    $stmt->execute();
    $stmt->close();
}

}
echo"<center><p style='color:white;'> Question and answer/s are added successfully!</p><center>"; 

}else{echo"<center><p style='color:black;'> please enter a question and at least one answer.</p><center>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Insert Question</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <link href="css/grid.css" type="text/css" rel="stylesheet">
</head>
<script>
    function addAnswerField(){
        const container = 
      document.getElementById("answers");
      const index = container . children.length;
      const div =document.createElement("div");
      div.className = "answer-field";
      div.innerHTML = `
      <input type="text" name="answers[]" placeholder="Enter answer option" required>
      <label>
      <input type="checkbox" name="correct[]" value="${index}">correct </label>
      
    `;container.appendChild(div);
    }
    </script>

    </head>
    <body>
        <div class="navbar"><h1>Quize App</h1>
            <button id="navToggle" class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
            <div class="nav-links">
                <a href="index.html">Home</a>
                <a href="about.php">About</a>
                <a href="services.php">Services</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
        <div class="container">
   <center> <h1> Add New Question<h1></center>
     <form action=""method="post">
        <label >Question:</label>
        <input type="text" id="question_text" name="question_text" required>
        
        <label>Category:</label>
        <select name="category" required style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
            <option value="General">General</option>
            <option value="Science">Science</option>
            <option value="History">History</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Technology">Technology</option>
        </select>
        
        <label style="margin-top: 10px;">Difficulty:</label>
        <select name="difficulty" required style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
            <option value="easy">Easy</option>
            <option value="medium" selected>Medium</option>
            <option value="hard">Hard</option>
        </select>
        
        <div id="answers">
            <div class="answer-field">
        <label >answers:</label>
        <input type="text"  name="answers[]" placeholder="Answer" required><br>
        
<label>Correct Answer:</label><br>
<label><input type="checkbox" name="correct[]" value="0">correct</label>
            </div>
        </div>
       
        <div class="add-answers-section">
            <h3>Add More Answers</h3>
            <button
        type="submit"
        class="submit-btn"
        onclick="addAnswerField()">
        Add Another Answer
    </button>
        </div> 
    <button type="submit" value="submit">Add Question</button>
        <a class='button' href='index.html'>Menu</a>     
    
    </form>
        </div>
    <script src="js/darkmode.js"></script>
    <script src="js/nav.js"></script>
</body>
</html>

