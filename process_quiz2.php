<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = 0;
    $answers = [2,1,4,2,3,3,3,3,2,2,1,2,2,3,3,3,1,2,3,4];
    $user_answers = [];
    $correct_answers = [];
    $wrong_answers = [];

    // Calculate score and collect answers
    for($i = 1; $i <= 20; $i++) {
        if(isset($_POST["qu$i"])) {
            $user_answers[$i] = $_POST["qu$i"];
            if($_POST["qu$i"] == $answers[$i-1]) {
                $result++;
                $correct_answers[$i] = true;
            } else {
                $wrong_answers[$i] = true;
            }
        }
    }

    // Connect to database and store result
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "WebProject");
    $ip = $_SERVER['REMOTE_ADDR'];
    $insert_query = "INSERT INTO quiz2_results (ip_address, score) VALUES ('$ip', '$result')";
    mysqli_query($conn, $insert_query);
    mysqli_close($conn);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quiz 2 Results</title>
    <link rel="stylesheet" href="css/styles.css" />
    <style>
        .result-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .score {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }
        .answer-review {
            margin-top: 2rem;
        }
        .question-review {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 5px;
        }
        .correct {
            background-color: #9cd1a0;
            border-left: 4px solid #4caf50;
        }
        .incorrect {
            background-color: #ff8d9e;
            border-left: 4px solid #f44336;
        }
        .question-text {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .answer-text {
            color: #666;
        }
        .correct-answer {
            color: #4caf50;
            font-weight: 500;
        }
        .retake-btn {
            display: block;
            width: 200px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #2196f3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
        }
        .retake-btn:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="quiz2.html">Quiz 2.</a>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="cv-switcher">
                    <a href="cv-anthony.html">CV</a>
                    <div class="cv-dropdown">
                        <a href="cv-anthony.html">
                            <span class="name">Anthony Abdo</span>
                            <span class="role">Web Developer</span>
                        </a>
                        <a href="cv-joseph.html">
                            <span class="name">Joseph Azzi</span>
                            <span class="role">Private Security Contractor</span>
                        </a>
                        <a href="cv-edward.html">
                            <span class="name">Edward Khazzoum</span>
                            <span class="role">Cybersecurity Expert</span>
                        </a>
                    </div>
                </li>
                <li><a href="research.html">Research</a></li>
                <li class="schedule-switcher">
                    <a href="schedule-anthony.html">Schedule</a>
                    <div class="schedule-dropdown">
                        <a href="schedule-anthony.html">
                            <span class="name">Anthony's Schedule</span>
                            <span class="role">Web Development</span>
                        </a>
                        <a href="schedule-edward.html">
                            <span class="name">Edward's Schedule</span>
                            <span class="role">Cybersecurity</span>
                        </a>
                        <a href="schedule-joseph.html">
                            <span class="name">Joseph's Schedule</span>
                            <span class="role">Security Operations</span>
                        </a>
                    </div>
                </li>
                <li><a href="media.html">Media</a></li>
                <li><a href="quiz.html">Quiz</a></li>
                <li><a href="quiz2.html" class="active">Quiz 2</a></li>
                <li><a href="arabic.html">Arabic</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <div class="result-container">
        <div class="score">
            Your Score: <?php echo $result; ?>/20
        </div>
        <div class="answer-review">
            <?php
            $questions = [
                1 => "What is included in the physical systems of Internet infrastructure?",
                2 => "What is the primary function of internet exchange points (IXPs)?",
                3 => "Which system is responsible for packet routing and forwarding in the Internet infrastructure?",
                4 => "In which year did Tim Berners-Lee and his team create the World Wide Web (WWW)?",
                5 => "Which protocol is used by the World Wide Web to transfer data?",
                6 => "What was the first web browser developed for public use?",
                7 => "What year was the browser Netscape Navigator first released?",
                8 => "Which of the following browsers was developed by Marc Andreessen's team?",
                9 => "What was the main reason behind the success of the first web browsers like Mosaic and Netscape?",
                10 => "What significant feature was introduced by Apple's Safari 2.0 in 2005?",
                11 => "Which network was developed in the 1960s and is considered a precursor to the modern Internet?",
                12 => "What event in the 1990s significantly fueled the growth of the World Wide Web?",
                13 => "Which e-commerce companies emerged during the dot-com boom?",
                14 => "In which year did Microsoft release Internet Explorer as part of Windows 95?",
                15 => "What was the first browser that introduced tabbed browsing?",
                16 => "Which of the following best describes Hypertext in the context of the World Wide Web?",
                17 => "What does HTTP stand for?",
                18 => "Which of the following is a key aspect of critical Internet infrastructure?",
                19 => "Which year did Apple launch Safari as the default browser for Macintosh computers?",
                20 => "As of 2024, what percentage of Lebanon's population used the internet?"
            ];

            $options = [
                1 => ["Smartphones", "Networking cables, cellular towers, and data centers", "Websites and blogs", "Social media platforms"],
                2 => ["They store and forward data between different networks", "They provide wireless communication for mobile devices", "They encrypt sensitive information", "They monitor internet traffic for security"],
                3 => ["Data centers", "Naming and numbering systems", "Security and identity protection", "Packet-switched networks"],
                4 => ["1985", "1989", "1992", "1995"],
                5 => ["FTP", "SMTP", "HTTP", "SNMP"],
                6 => ["Netscape Navigator", "Internet Explorer", "Mosaic", "Safari"],
                7 => ["1992", "1993", "1994", "1995"],
                8 => ["Safari", "Internet Explorer", "Mosaic", "Opera"],
                9 => ["They were text-based", "They allowed easy navigation with clickable links", "They required high-speed internet connections", "They were only available on UNIX systems"],
                10 => ["Pop-up blocker", "Private Browsing", "Video streaming support", "Tabbed browsing"],
                11 => ["ARPANET", "TCP/IP", "Ethernet", "Wi-Fi"],
                12 => ["The introduction of mobile technology", "The dot-com boom", "The creation of the first email client", "The development of the first search engine"],
                13 => ["Facebook and Twitter", "Amazon and eBay", "Microsoft and Google", "Apple and IBM"],
                14 => ["1993", "1994", "1995", "1996"],
                15 => ["Netscape Navigator", "Internet Explorer", "Opera", "Firefox"],
                16 => ["Text-based documents linked by URLs", "Images, sounds, and animations linked together", "Clickable words or phrases to navigate to other information", "Data transmission using secure protocols"],
                17 => ["HyperText Transfer Protocol", "HyperText Transport Protocol", "Hyperlink Transmission Protocol", "HyperTerminal Transfer Protocol"],
                18 => ["Social media platforms", "Naming and numbering systems", "Video streaming services", "Email clients"],
                19 => ["1998", "2000", "2003", "2005"],
                20 => ["70.2%", "80.5%", "85.6%", "90.1%"]
            ];

            foreach ($questions as $q_num => $question) {
                $class = isset($correct_answers[$q_num]) ? "correct" : "incorrect";
                echo "<div class='question-review $class'>";
                echo "<div class='question-text'>Question $q_num: $question</div>";
                if (isset($user_answers[$q_num])) {
                    echo "<div class='answer-text'>Your answer: " . $options[$q_num][$user_answers[$q_num]-1] . "</div>";
                } else {
                    echo "<div class='answer-text'>Your answer: Not answered</div>";
                }
                echo "<div class='correct-answer'>Correct answer: " . $options[$q_num][$answers[$q_num-1]-1] . "</div>";
                echo "</div>";
            }
            ?>
        </div>
        <a href="quiz2.html" class="retake-btn">Retake Quiz</a>
    </div>
    <footer>
        <div class="footer-content">
            <div class="social-links">
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <p class="footer-tech">© 2024 My Website</p>
    </footer>
    <script src="js/main.js"></script>
</body>
</html> 