<template>
  <div>
    <NavBar></NavBar>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import NavBar from "@/views/NavBar.vue";
export default {
  components: {
    NavBar,
  },
  setup() {
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

    return { currentUser, handleLogout, logoutStatus };
  },
};
</script>
