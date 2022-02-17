 <?php
include_once ("connect.php");
 $show_student = "Select * from student;";
 $result_student = $conn->query($show_student);
 $result_row_count = mysqli_num_rows($result_student);
 $num_per_page = 7;
 $total_pages = ceil($result_row_count/$num_per_page);
 if(!isset($_GET["page"])){
     $page = 1;
 }
 else{
     $page = $_GET["page"];
 }
 $start_from = ($page-1) * $num_per_page;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Student</title>
    <link rel="stylesheet" href="jpschool.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>  
<body class='body'>
    <div class="logo">
        <img class="log" src="./Fresh Schools Management/Logo.png" alt="">
    </div>
    <div class="leftbar">
        <div class = "leftheading"><span style="font-weight : bold;">SCHOOL MANAGEMENT</span></div>
        <div id = "leftcontent1" class = "leftimage"><img src="./Fresh Schools Management/City List.png" alt=""><a id = "lefttopics1" class = "lefttopics" href="jpcity.php">City List</a></div>
        <div id = "leftcontent2" class = "leftimage"><img src="./Fresh Schools Management/School Listt.png" alt=""><a id = "lefttopics2" class = "lefttopics" href="jpschool.php">School List</a></div>
        <div id = "leftcontent3" class = "leftimage"><img src="./Fresh Schools Management/Class List.png" alt=""><a id = "lefttopics3" class = "lefttopics" href="jpclass.php">Class List</a></div>
        <div class = "leftimage"style = "background-color : #f6f8fa; border-left : 5px solid #d642c8;"><img src="./Fresh Schools Management/Student List.png" alt=""><a style = "color : #d642c8;" class = "lefttopics" href="jpstudent.php">Student List</a></div>
   </div>
   <div class="maincontainer"> 
       <div class="topcontainer">
       <div id = "city_list"><span class = "city_top"><b>Student List</b></span></div>
       <div id = "city_list"><span class = "total_cities">Total Student - <?php echo $result_row_count;?></span></div>
       <div id = "city_list"><input type="text" class = "search_box" onfocus="this.placeholder=''" onblur="this.placeholder='search'" placeholder = "search"><img class = "search_tool" src="./Fresh Schools Management/Search Icon.png" alt=""><img class = "filterimage" src="./Fresh Schools Management/Filter.png" alt=""><span><button class = "filter" >Filter</button></span></div>
       <ul id = "filter_info" class = "filter_dropdown">
           <li><b> Age</b></li>
           <li><input class = "input" type="radio" name = "age" value = "3 and 5"> 3 to 5</li>
           <li><input class = "input" type="radio" name = "age" value = "6 and 9"> 6 to 9</li>
           <li><input class = "input" type="radio" name = "age" value = "10 and 12"> 10 to 12</li>
           <li><input class = "input" type="radio" name = "age" value = "13 and 15"> 13 to 15</li>
           <li><input class = "input" type="radio" name = "age" value = "16 and 18"> 16 to 18</li>
       </ul>      
       </div>
       <table>
           <tr class = "th_row">
               <th>Sl.No</th>
               <th>Student ID</th>
               <th>Student Name</th>
               <th>Gender</th>
               <th>Age</th>
               <th>Father Name</th>
               <th>Mobile Number</th>
               <th>Class ID</th>
               <th></th>
               <th></th>
           </tr>
           <tbody id = "table_student" class = "table_body">
           <?php
                if(isset($_POST["age"])){
                    $age=$_POST["age"];
                    $filter_query = "SELECT * from student where age between $age";
                    $result_filter = $conn->query($filter_query);
                    while($row = $result_filter->fetch_assoc()){
                       
            ?>
                <tr id = "table1_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['student_id'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['father_name'];?></td>
                    <td><?php echo $row['mobile_number'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td></td>
                    <td></td>
            <?php
                    }
                    
                }
                elseif(isset($_GET["classid"])){
                    $class_id = $_GET["classid"];
                    $class_innerjoin = "SELECT student.si_no,student.student_id,student.student_name,student.gender,student.age,student.father_name,student.mobile_number,student.class_id FROM class INNER JOIN student ON class.class_id = student.class_id WHERE student.class_id = '$class_id'";
                    $result_classid_innerjoin = $conn->query($class_innerjoin);
                    while($row = $result_classid_innerjoin->fetch_assoc()){
            ?>
                <tr id = "table1_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['student_id'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['father_name'];?></td>
                    <td><?php echo $row['mobile_number'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td></td>
                    <td></td>
            <?php
                    }
                                
                }
                elseif(isset($_GET["schoolid"])){
                    $school_id = $_GET["schoolid"];
                    $school_innerjoin = "SELECT student.si_no,student.student_id,student.student_name,student.gender,student.age,student.father_name,student.mobile_number,student.class_id FROM school INNER JOIN class ON school.school_id = class.school_id INNER JOIN student on class.class_id = student.class_id where school.school_id = '$school_id'";
                    $result_schoolid_innerjoin = $conn->query($school_innerjoin);
                    while($row = $result_schoolid_innerjoin->fetch_assoc()){
            ?>
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['student_id'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['father_name'];?></td>
                    <td><?php echo $row['mobile_number'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td></td>
                    <td></td>
            <?php
                    }
                                
                }
                else{ 
                    $page_wise_sql = "SELECT * from student limit $start_from, $num_per_page;";
                    $result_student_limit = $conn->query($page_wise_sql);
                    while($row = $result_student_limit->fetch_assoc()){
            ?>
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['student_id'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['father_name'];?></td>
                    <td><?php echo $row['mobile_number'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td></td>
                    <td></td>
            <?php
                    }
                }
            ?>
            </tbody>
       </table>
       <div class="no_datas">No Data Found</div>
   </div>
   <div style = "text-align: right; margin-right: 30px;" class="bottomcontainer">
        <span>Page</span>
        <?php
            for($page=1;$page<=$total_pages;$page++){
        ?>
                <span><a style = "text-decoration: none; color: black" href="jpstudent.php?page=<?php echo $page;?>"><?php echo $page;?></a></span>
        <?php
            }
        ?>
    </div>
    <script>
        $(document).ready(function(){
            $(".search_box").on("keyup", function(){
                var value = $(this).val().toLowerCase();
                $(".table_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    var empty = $(".table_body tr:not('.no-datas'):visible")
                    if(empty.length==0)
                    {
                        $(".no_datas").css("display","inline");
                        if(empty.length > 0){
                            $(".no_datas").css("display","none");
                        $(".search_box").on("keyup", function(){
                            var value = $(this).val().toLowerCase();
                            $(".table_body tr").filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                
                            });
                        });
                    }
                    // $(".table_body").html("<tr class='no-datas'><td style = 'width: 100%;'>No Data Found..</td></tr>");
                    }
                    else
                    {
                        $(".no_datas").css("display","none");
                    // $(".no-datas").remove();
                    }  
                    
                });
                
                
            });
       
            $(".filter").click(function(){
            $(".filter_dropdown").slideToggle();
            });
        });
    </script>
    <script src = "jpstudent.js"></script>
    
</html>