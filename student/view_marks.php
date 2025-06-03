<?php
// Start session
session_start();

// Include necessary files
include_once("../includes/config.php");
include_once("../includes/functions.php");

// Check if student is logged in
check_login("student");

// Get student ID
$student_id = $_SESSION['student'];

// Get student marks
$sql = "SELECT m.*, f.name as faculty_name 
        FROM marks m 
        JOIN faculty f ON m.faculty_id = f.id 
        WHERE m.student_id = $student_id 
        ORDER BY m.exam_type, m.subject";
$result = mysqli_query($conn, $sql);
?>
<?php include_once("../includes/header.php"); ?>

<h2>My Exam Marks</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
<table class="data-table">
    <thead>
        <tr>
            <th>Exam Type</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Max Marks</th>
            <th>Percentage</th>
            <th>Added By</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $current_exam = '';
        $exam_total = 0;
        $exam_max = 0;
        $exam_subjects = 0;
        
        while($row = mysqli_fetch_assoc($result)): 
            // If new exam type, show summary of previous exam type
            if ($current_exam != '' && $current_exam != $row['exam_type'] && $exam_subjects > 0) {
                echo '<tr class="summary-row" style="background-color: #f2f2f2; font-weight: bold;">';
                echo '<td colspan="2">' . $current_exam . ' Summary</td>';
                echo '<td>' . $exam_total . '</td>';
                echo '<td>' . $exam_max . '</td>';
                echo '<td>' . number_format(($exam_total / $exam_max) * 100, 2) . '%</td>';
                echo '<td></td>';
                echo '</tr>';
                
                // Reset counters
                $exam_total = 0;
                $exam_max = 0;
                $exam_subjects = 0;
            }
            
            // Set current exam
            $current_exam = $row['exam_type'];
            
            // Add to exam totals
            $exam_total += $row['marks'];
            $exam_max += $row['max_marks'];
            $exam_subjects++;
        ?>
        <tr>
            <td><?php echo $row['exam_type']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['max_marks']; ?></td>
            <td><?php echo number_format(($row['marks'] / $row['max_marks']) * 100, 2); ?>%</td>
            <td><?php echo $row['faculty_name']; ?></td>
        </tr>
        <?php endwhile; ?>
        
        <?php 
        // Show summary for the last exam type
        if ($exam_subjects > 0) {
            echo '<tr class="summary-row" style="background-color: #f2f2f2; font-weight: bold;">';
            echo '<td colspan="2">' . $current_exam . ' Summary</td>';
            echo '<td>' . $exam_total . '</td>';
            echo '<td>' . $exam_max . '</td>';
            echo '<td>' . number_format(($exam_total / $exam_max) * 100, 2) . '%</td>';
            echo '<td></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php else: ?>
<p>No marks found. Your faculty members will add marks after exams.</p>
<?php endif; ?>

<?php include_once("../includes/footer.php"); ?>