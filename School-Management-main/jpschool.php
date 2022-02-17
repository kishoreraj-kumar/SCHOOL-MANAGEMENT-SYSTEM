<?php
include_once ("connect.php");
$show_school = "Select * from school;";
$result_school = $conn->query($show_school);
$result_row_count = mysqli_num_rows($result_school);
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
    <title>School</title>
    <link rel="stylesheet" href="jpschool.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>  
<body id = "bodys" class = "body">
    <div class="logo">
        <img class="log" src="./Fresh Schools Management/Logo.png" alt="">
    </div>
    <div class="leftbar">
        <div class = "leftheading"><span style="font-weight : bold;">SCHOOL MANAGEMENT</span></div>
        <div id = "leftcontent1" class = "leftimage"><img src="./Fresh Schools Management/City List.png" alt=""><a id = "lefttopics1" class = "lefttopics" href="jpcity.php">City List</a></div>
        <div class = "leftimage" style = "background-color : #f6f8fa; border-left: 5px solid #3dbce8;"><img src="./Fresh Schools Management/School Listt.png" alt=""><a style = "color : #3dbce8;" href="jpschool.php" class = "lefttopics">School List</a></div>
        <div id = "leftcontent3" class = "leftimage"><img src="./Fresh Schools Management/Class List.png" alt=""><a id = "lefttopics3" class = "lefttopics" href="jpclass.php">Class List</a></div>
        <div id = "leftcontent4" class = "leftimage"><img src="./Fresh Schools Management/Student List.png" alt=""><a id = "lefttopics4" class = "lefttopics" href="jpstudent.php">Student List</a></div>
   </div>
   <div class="maincontainer"> 
       <div class="topcontainer">
       <div id = "city_list"><span class = "city_top"><b>School List</b></span></div>
       <div id = "city_list"><span class = "total_cities">Total School - <?php echo $result_row_count;?></span></div>
       <div id = "city_list"><input type="text"   class = "search_box" onfocus="this.placeholder=''" onblur="this.placeholder='search'" placeholder = "search"><img class = "search_tool" src="./Fresh Schools Management/Search Icon.png" alt=""></div>
       </div>
       <table id = "table">
           <tr class = "th_row">
               <th>Sl.No</th>
               <th>School ID</th>
               <th>School Name</th>
               <th>City ID</th>
               <th>City Name</th>
               <th>State</th>
               <th>Country</th>
               <th>Action</th>
               <th></th>  
           </tr>
           <tbody class = "table_body">
           <?php    
                    
                if(isset($_GET["cityid"])){
                    $city_id = $_GET["cityid"];
                    $city_innerjoin = "SELECT school.si_no,school.school_id,school.school_name,school.city_id,school.city_name,school.state,school.country,school.action,school.action1 FROM city INNER JOIN school ON city.city_id = school.city_id WHERE school.city_id = '$city_id'";
                    $result_innerjoin = $conn->query($city_innerjoin);
                    while($rows = $result_innerjoin->fetch_assoc()){
           ?>
           
                <tr>
                    <td><?php echo $rows['si_no'];?></td>
                    <td><?php echo $rows['school_id'];?></td>
                    <td><?php echo $rows['school_name'];?></td>
                    <td><?php echo $rows['city_id'];?></td>
                    <td><?php echo $rows['city_name'];?></td>
                    <td><?php echo $rows['state'];?></td>
                    <td><?php echo $rows['country'];?></td>
                    <td><a class = "all_class" href="jpclass.php?schoolid=<?php echo $rows['school_id'];?>"><?php echo $rows['action'];?></a></td>
                    <td><a class = "all_student" href="jpstudent.php?schoolid=<?php echo $rows['school_id'];?>"><?php echo $rows['action1'];?></a></td>
                </tr>
           <?php
                    }
                }    
                else{
                    $start_from = ($page-1) * $num_per_page;
                    $page_wise_sql = "SELECT * from school limit $start_from, $num_per_page";
                    $result_school_limit = $conn->query($page_wise_sql);
                    while($row = $result_school_limit->fetch_assoc()){
            ?>
            
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['school_id'];?></td>
                    <td><?php echo $row['school_name'];?></td>
                    <td><?php echo $row['city_id'];?></td>
                    <td><?php echo $row['city_name'];?></td>
                    <td><?php echo $row['state'];?></td>
                    <td><?php echo $row['country'];?></td>
                    <td><a class = "all_class" href="jpclass.php?schoolid=<?php echo $row['school_id'];?>"><?php echo $row['action'];?></a></td>
                    <td><a class = "all_student" href="jpstudent.php?schoolid=<?php echo $row['school_id'];?>"><?php echo $row['action1'];?></a></td>
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
                <span style = "text-align: center;"><a style = "text-decoration: none; color: black" href="jpschool.php?page=<?php echo $page;?>"><?php echo $page;?></a></span>
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
