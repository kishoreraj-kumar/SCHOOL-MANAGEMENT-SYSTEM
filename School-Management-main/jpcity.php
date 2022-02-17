<?php
include_once ("connect.php");
$show_city = "Select * from city;";
$result_city = $conn->query($show_city);
$result_row_count = mysqli_num_rows($result_city);
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
    <title>City</title>
    <link rel="stylesheet" href="jpschool.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>  
<body class = "jpcity">
    <div class="logo">
        <img class="log" src="./Fresh Schools Management/Logo.png" alt="">
    </div>
    <div class="leftbar">
        <div class = "leftheading"><span style="font-weight : bold;">SCHOOL MANAGEMENT</span></div>
        <div class = "leftimage" style = "background-color : #f6f8fa; border-left : 5px solid #225fad;"><img src="./Fresh Schools Management/City List.png" alt=""><span style = "color : #225fad;" class = "lefttopics">City List</span></div>
        <div id = "leftcontent2" class = "leftimage"><img src="./Fresh Schools Management/School Listt.png" alt=""><a id = "lefttopics2" class = "lefttopics" href="jpschool.php">School List</a></div>
        <div id = "leftcontent3" class = "leftimage"><img src="./Fresh Schools Management/Class List.png" alt=""><a id = "lefttopics3" class = "lefttopics" href="jpclass.php">Class List</a></div>
        <div id = "leftcontent4" class = "leftimage"><img src="./Fresh Schools Management/Student List.png" alt=""><a id = "lefttopics4" class = "lefttopics" href="jpstudent.php">Student List</a></div>
   </div>
   <div class="maincontainer"> 
       <div class="topcontainer">
        <div id = "city_list"><span class = "city_top"><b>City List</b></span></div>
        <div id = "city_list"><span class = "total_cities">Total Cities - <?php echo $result_row_count;?></span></div>
        <div id = "city_list"><input type="text" class = "search_box" onfocus="this.placeholder=''" onblur="this.placeholder='search'" placeholder = "search"><img class = "search_tool" src="./Fresh Schools Management/Search Icon.png" alt=""></div>
       </div>
       <table>
            <thead>
                <tr class = "th_row">
                    <th>Sl.No</th>
                    <th>City ID</th>
                    <th>City Name</th>
                    <th>State</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class = "table_body">
            <?php 
                $start_from = ($page-1) * $num_per_page;
                $page_wise_sql = "SELECT * from city limit $start_from, $num_per_page;";
                $result_city_limit = $conn->query($page_wise_sql);
                while($row = $result_city_limit->fetch_assoc()){
            ?>
            
                <tr id = "table_tr">
                    <td><?php echo $row['si_no'];?></td>
                    <td><?php echo $row['city_id'];?></td>
                    <td class= "city"><a href="jpschool.php?cityid=<?php echo $row['city_id'];?>" class = "all_class" ><?php echo $row['city_name'];?></a></td>
                    <td><?php echo $row['state'];?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            
            <?php
                }
            ?>
            </tbody>
       </table>
       <div class="no_datas">No Data Found</div>
   </div>
   <div style = "text-align: right; margin-right: 30px;" class="bottomcontainer">
        <span">Page</span>
        <?php
            for($page=1;$page<=$total_pages;$page++){
        ?>
                <!-- <span><a style = "text-decoration: none; color: black;" href="jpcity.php?page=<?php echo $page;?>"><?php echo $page;?></a> of <a style = "text-decoration: none; color: black;" href=""><?php echo $total_pages;?></a></span> -->
                <span><a style = "text-decoration: none; color: black;" href="jpcity.php?page=<?php echo $page;?>"><?php echo $page;?></a></span>
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
    <script src = "jpcity.js"></script>
</body>
</html>