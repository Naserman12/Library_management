   
   
   <div class="content_sec">
            <form action="adminpanel.php?page=sections" method="POST">
                <label for="section" >التحكم بالاقسام</label>
                <input type="text" name="catyName" class="section"  required>
                <br>
                <button class="add" type="submit"><i class="fa-solid fa-plus"></i>اضافةالقسم</button>
            </form>
            <br>
            <!-- tatel -->
            <table dir="rlt">
                <!-- عناوين الجدول -->
                <tr>
                    <th>الرقم التسلسلي</th>
                    <th>القسم</th>
                    <th>تعديل القسم</th>
                    <th>حذف القسم</th>
                </tr>
                <!--// عناوين الجدول //-->
                <?php
                $category = $category->getCaty();
                 foreach($category as $row): ?>
                <!-- بيانات الجدول -->
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    
                    <td><a href="../BOOKS/editCaty.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-edit"></i>تعديل</a></td>
                    <td><a  class="del_btn" onclick="return confirm('هل انت تريد حذف التصنيف؟؟.')"  href="../BOOKS/deleteCaty.php?id=<?php echo $row['id']; ?>">حذف</a></td>
                </tr>
                <!--// بيانات الجدول //-->
                <?php endforeach; ?>
                </table>
                <!--// tatel //-->
         </div>