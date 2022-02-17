<?php
include "connect.php";
$show_class = "Select * from class;";
$result_class = $conn->query($show_class);
$result_row_count = mysqli_num_rows($result_class);
$num_per_page = 7;
$total_pages = ceil($result_row_count/$num_per_page);
if(!isset($_GET["page"])){
    $page = 1;
}
else{
    $page = $_GET["page"];
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class</title>
    <link rel="stylesheet" href="jpschool.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>  
<body>
    <div class="logo">
        <img class="log" src="./Fresh Schools Management/Logo.png" alt="">
    </div>
    <div class="leftbar">
        <div class = "leftheading"><span style="font-weight : bold;">SCHOOL MANAGEMENT</span></div>
        <div id = "leftcontent1" class = "leftimage"><img src="./Fresh Schools Management/City List.png" alt=""><a id = "lefttopics1" class = "lefttopics" href="jpcity.php">City List</a></div>
        <div id = "leftcontent2" class = "leftimage"><img src="./Fresh Schools Management/School Listt.png" alt=""><a id = "lefttopics2" class = "lefttopics" href="jpschool.php">School List</a></div>
        <div class = "leftimage" style = "background-color : #f6f8fa; border-left : 5px solid #444444;"><img src="./Fresh Schools Management/Class List.png" alt=""><span style = "color : #444444;"class = "lefttopics">Class List</span></div>
        <div id = "leftcontent4" class = "leftimage"><img src="./Fresh Schools Management/Student List.png" alt=""><a id = "lefttopics4" class = "lefttopics" href="jpstudent.php">Student List</a></div>
   </div>
   <div class="maincontainer"> 
       <div class="topcontainer">
       <div id = "city_list"><span class = "city_top"><b>Class List</b></span></div>
       <div id = "city_list"><span class = "total_cities">Total Class - <?php echo $result_row_count;?></span></div>
       <div id = "city_list"><input type="text"   class = "search_box" onfocus="this.placeholder=''" onblur="this.placeholder='search'" placeholder = "search"><img class = "search_tool" src="./Fresh Schools Management/Search Icon.png" alt=""></div>
       </div>
       <table>
            <tr class = "th_row">
               <th>Sl.No</th>
               <th>Class ID</th>
               <th>Standard</th>
               <th>Section</th>
               <th>School ID</th>
               <th>Action</th>
               <th></th>
               <th></th>
               <th></th>
            </tr>
            <tbody id = "table_student" class = "table_body">
           <?php
                if(isset($_GET["schoolid"])){
                    $school_id = $_GET["schoolid"];
                    $school_innerjoin = "SELECT class.si_no,class.class_id,class.standard,class.section,class.school_id,class.action FROM school INNER JOIN class ON school.school_id = class.school_id WHERE class.school_id = '$school_id'";
                    $result_schoolid_innerjoin = $conn->query($school_innerjoin);
                    while($row = $result_schoolid_innerjoin->fetch_assoc()){
            ?>
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td><?php echo $row['standard'];?></td>
                    <td><?php echo $row['section'];?></td>
                    <td><?php echo $row['school_id'];?></td>
                    <td><a class = "all_class" href="jpstudent.php?classid=<?php echo $row['class_id'];?>"><?php echo $row['action'];?></a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php
                    }
                }
                else{
                    $start_from = ($page-1) * $num_per_page;
                    $page_wise_sql = "SELECT * from class limit $start_from, $num_per_page;";
                    $result_class_limit = $conn->query($page_wise_sql);
                    while($row = $result_class_limit->fetch_assoc()){
            ?>
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td><?php echo $row['standard'];?></td>
                    <td><?php echo $row['section'];?></td>
                    <td><?php echo $row['school_id'];?></td>
                    <td><a class = "all_class" href="jpstudent.php?classid=<?php echo $row['class_id'];?>"><?php echo $row['action'];?></a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php
                    }
                }
            ?>
            </tbody>
       </table>
       <div class="no_datas">No Data Found</div>
   </div>
   <div style = "text-align: right; margin-right: 30px;" class="bottomcontainer">
        <span style = "text-align: center;">Page</span>
        <?php
            for($page=1;$page<=$total_pages;$page++){
        ?>
                <span style = "text-align: center;"><a style = "text-decoration: none; color: black" href="jpclass.php?page=<?php echo $page;?>"><?php echo $page;?></a></span>
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
            $(".search_box").focusin(function(){
                $(".search_tool").css("display","none");
            });
            $(".search_box").focusout(function(){
                $(".search_tool").css("display","inline");
            });
        });
    </script>
</body>
</html>