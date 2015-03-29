<?php include VIEW_PATH . 'Header.php' ?>

<form action="<?php echo BASE_URL . 'user/submitSignUp';?>" method="post">
    <label>Email*:</label>
    <input type="text" name="email"/> <br/>

    <label>Mật khẩu*:</label>
    <input type="password" name="password"/> <br/>

    <label>Nhập lại mật khẩu*:</label>
    <input type="password" name="retypePassword"/> <br/>

    <br/>
    <br/>
    <label>Thông tin bổ sung (không bắt buộc)</label>
    <hr/>
    <label>Mã số:</label>
    <input type="text" name="studentID"/> <br/>

    <label>CMND:</label>
    <input type="text" name="IDcard"/> <br/>

    <label>Số điện thoại:</label>
    <input type="text" name="tel"/> <br/>

    <label>Ngày sinh:</label>
    <input type="datetime" name="birth"/> <br/>

    <label>Giới tính:</label>
    <input type="radio" name="sex" value="Male"/>
    <label>Nam</label>
    <input type="radio" name="sex" value="Female"/>
    <label>Nữ</label>

    <label>Địa chỉ:</label>
    <input type="text" name="address"/> <br/>

    <input type="checkbox" name="coinConfirm" value="1"/>
    <label>Mọi thao tác dùng xu đều phải xác nhận qua mail/số điện thoại</label>

    <hr/>
    <input type="checkbox" name="TOS" value="1"/>
    <label>Tôi đồng ý trên <a href="TOS.php">các điều khoản sử dụng</a></label> <br/>

    <input type="button" name="SignUp" value="Đăng Kí"/>

</form>

<?php include VIEW_PATH . 'Footer.php' ?>