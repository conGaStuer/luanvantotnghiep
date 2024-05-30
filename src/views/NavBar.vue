<template>
  <div>
    <div class="top-bar">
      <div class="top-bar-contain">
        <b> FREE SHIPPING WORLDWIDE </b>
        <div class="contact">
          <i class="fa-solid fa-phone"></i><span> CONTACT US</span>
          <i class="fa-regular fa-heart"></i><span> WISHLIST </span>
        </div>
        <div class="social-icons">
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    <header class="header">
      <div class="logo">
        <img src="@/assets/images/logo1.png" alt="BookChoix Logo" />
      </div>
      <ul class="nav-links">
        <li class="nav-item">
          <a href="#">HOME </a>
        </li>
        <li class="nav-item" @mouseover="showMegaMenu">
          <a href="#">MEGA MENU <i class="fas fa-chevron-down"></i></a>
          <transition name="fade">
            <div
              class="mega-menu"
              v-if="megaMenuVisible"
              @mouseleave="hideMegaMenu"
            >
              <div class="column">
                <h3>TEXT BOOKS</h3>
                <a href="#">Business</a>
                <a href="#">Encyclopedias</a>
                <a href="#">Lifestyle</a>
                <a href="#">Foods & Cookery</a>
                <a href="#">Fantasy</a>
              </div>
              <div class="column">
                <h3>KINDLE BOOKS</h3>
                <a href="#">Architecture</a>
                <a href="#">Biography</a>
                <a href="#">Music</a>
                <a href="#">Wildlife</a>
                <a href="#">Cooking</a>
              </div>
              <div class="column">
                <h3>PAGES</h3>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Refund And Returns Policy</a>
                <a href="#">Terms And Conditions</a>
              </div>
              <div class="column">
                <img src="@/assets/images/book.jpg" alt="BookChoix Logo" />
              </div>
            </div>
          </transition>
        </li>
        <li><a href="#">SHOP</a></li>
        <li><a href="#">BLOG</a></li>
        <li class="nav-item" @mouseover="showPage">
          <a href="#">PAGES <i class="fas fa-chevron-down"></i></a>
          <ul class="dropdown" @mouseleave="hidePage" v-if="pageVisible">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </li>
        <li><a href="#">CONTACT US</a></li>
      </ul>
      <div class="cart-search">
        <a href="#" class="wishlist"
          ><i class="fa-solid fa-user" @click="showUserDropdown"></i
        ></a>
        <transition name="fade">
          <div
            class="dropdown1"
            v-if="userDropdownVisible"
            @mouseleave="hideUserDropdown"
          >
            <div>
              <a href="#"
                >Xin chào,
                {{ currentUser ? currentUser.taikhoan : "Khách hàng" }}!</a
              >
            </div>

            <div><router-link to="/profile" href="#">Hồ sơ</router-link></div>
            <div><a href="#">Đơn mua</a></div>
            <div><button @click="handleLogout">Đăng xuất</button></div>
          </div>
        </transition>
        <a href="#" class="cart">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count">0</span>
        </a>
        <a href="#" class="search"><i class="fas fa-search"></i></a>
      </div>
    </header>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
export default {
  setup() {
    // Dùng ref thay cho data()
    const megaMenuVisible = ref(false);
    const userDropdownVisible = ref(false); // Thêm một ref mới cho dropdown người dùng
    const pageVisible = ref(false);

    // Các phương thức cho mega menu
    const showMegaMenu = () => {
      megaMenuVisible.value = true;
    };

    const hideMegaMenu = () => {
      megaMenuVisible.value = false;
    };

    // Các phương thức mới cho dropdown người dùng
    const showUserDropdown = () => {
      userDropdownVisible.value = true;
    };

    const hideUserDropdown = () => {
      userDropdownVisible.value = false;
    };

    const showPage = () => {
      pageVisible.value = true;
    };

    const hidePage = () => {
      pageVisible.value = false;
    };
    const currentUser = JSON.parse(localStorage.getItem("currentUser"));
    const logoutStatus = ref(null);
    const router = useRouter();

    const handleLogout = async () => {
      try {
        const response = await axios.get(
          "http://localhost/LVTN/book-store/src/api/logout.php"
        );
        if (response) {
          localStorage.removeItem("currentUser");
          logoutStatus.value = true;
          // Chuyển hướng đến trang đăng nhập hoặc trang chính của ứng dụng
          router.push("/login");
        } else {
          logoutStatus.value = false;
          alert("Đã xảy ra lỗi khi đăng xuất");
        }
      } catch (error) {
        console.error("Lỗi:", error);
        logoutStatus.value = false;
        alert("Đã xảy ra lỗi khi đăng xuất");
      }
    };
    const redirectIfLoggedIn = () => {
      if (currentUser) {
        router.replace("/"); // Redirect to the main page if logged in
      }
    };

    onMounted(() => {
      if (router.currentRoute.value.path === "/login") {
        redirectIfLoggedIn();
      }
    });

    // Trả về các biến và phương thức cần thiết cho component
    return {
      megaMenuVisible,
      userDropdownVisible, // Biến ref mới cho dropdown người dùng
      pageVisible,
      showMegaMenu,
      hideMegaMenu,
      showUserDropdown,
      hideUserDropdown,
      showPage,
      hidePage,
      currentUser,
      handleLogout,
      logoutStatus,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/assets/styles/navbar.scss";
</style>
