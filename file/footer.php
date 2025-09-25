<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector(".user-toggle");
    const dropdown = document.getElementById("userDropdown");

    toggleButton.addEventListener("click", function (event) {
      event.stopPropagation(); // يمنع الإغلاق الفوري
      dropdown.classList.toggle("active"); // استخدم "active" بدل "show"
    });

    // إغلاق القائمة عند الضغط خارجها
    window.addEventListener("click", function (event) {
      const userMenu = document.getElementById("userMenu");
      if (!userMenu.contains(event.target)) {
        dropdown.classList.remove("active");
      }
    });
  });
</script>


<!-- foooter -->
<footer>
    <div class="google_maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12867.196965001358!2d49.60828979284292!3d25.353725511428586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e3791a00648e617%3A0x727a00be45f03a08!2z2KfZhNiy2KfYryDYp9mE2LTYp9mF2Yo!5e0!3m2!1sar!2ssa!4v1728528803270!5m2!1sar!2ssa" width="100%" height="85%" style="border:3;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="copy">
        <p>
            جيم &copy; 2025 جميع الحقوق محفوظة
        </p>
    </div>
</footer>
<!--// foooter// -->
</body>
</html>
