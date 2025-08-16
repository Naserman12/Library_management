<style>
        body{
            text-align: center;
            align-items: center;
           background-color: darkslategrey;
           color: white;
          
        }
        h1{
            margin-bottom: 0;
            margin-top: 10px;
        }
        table{
            margin-top: 0;
            width: 100%;
            height: 420px;
            background-color: whitesmoke;
            margin-bottom: 2px;
            color: saddlebrown;
        }
     a , h3 a {
    width: 90%;
    height: 25px;
    /* background-color: rgb(126, 123, 129); */
    font-size: 18px;
    padding: 10px 20px;
    cursor: pointer;
    text-decoration: none;
    color: blue;
}    
h3 {
    background-color:white ;
}
    </style>
<?php
session_start();
// include '../USERS/MemberClass.php';
include '../BOOKS/Book.php';

// <---------جلب الاعضاء منن قاعدة البيانات-------->
$sql = "SELECT id, name, email, phone, role FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
      ?>
      <!DOCTYPE html>
      <html lang="ar" dir="rlt">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>صفحة الاعضاء</title>
      </head>
      <body>
          <h1>صفحة عرض الاعضاء</h1>
          <table>
          <tr>
        <td>اسم العضو</td>
        <td>البريد الاكتروني</td>
        <td>رقم التواصل</td>
        <td>الدور</td>
        <td>ترقية</td>
       </tr>
          <?php
          while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php if($row['role'] === 'admin'){
                    echo 'مدير';
                }else{
                    echo 'عضو';
                }
                 ; ?></td>
                <?php 
                if ($row['role'] == 'members') {
                    ?>
                    <!-- <td><a href="promote.php?id=" <?php $row['id'] ?>>ترقية الى مدير</a></td> -->
                    <td><a href="../admin/promote.php?id="<?php echo  $row['id']; ?>>ترقية الى مشرف </a></td><br>
                    <?php

          }else{
              echo '<td>== مشرف ==</td>';
            }
           echo '</tr>';
        }
        echo '</table>';
    }else{
        echo 'لايوجد اعضاء';
    }
    
    ?>
    <h3><a href="../Reports/book_reports.php">ملخص المكتب.</a></h3>
    </tr>
    </table>
          </body>
          </html>