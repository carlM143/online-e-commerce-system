<template>
  <div class="home">
    <h1>🛍️ Featured Products</h1>

    <div v-if="loading" class="loading">Loading products...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <div v-else class="product-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <img
          :src="product.image_url"
          :alt="product.name"
          @click="openModal(product)"
          class="clickable"
        />
        <h3 @click="openModal(product)" class="clickable">{{ product.name }}</h3>
        <p class="price">${{ Number(product.price).toFixed(2) }}</p>
        <button @click="addToCart(product)">Add to Cart</button>
      </div>
    </div>

    <!-- Product Details Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <button class="close-btn" @click="closeModal">×</button>
        <img :src="selectedProduct.image_url" alt="Product Image" class="modal-image" />
        <h2 class="modal-title">{{ selectedProduct.name }}</h2>
        <p class="modal-description">{{ selectedProduct.description }}</p>
        <p class="modal-price">${{ Number(selectedProduct.price).toFixed(2) }}</p>
        <button class="modal-cart-btn" @click="addToCart(selectedProduct)">
          🛒 Add to Cart
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Home",
  data() {
    return {
      products: [],
      loading: true,
      error: null,
      showModal: false,
      selectedProduct: {},
    };
  },
  async created() {
    try {
      const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/products`);
      this.products = response.data;
    } catch (err) {
      this.error = "Failed to load products. Please try again later.";
      console.error("API Error:", err);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    openModal(product) {
      this.selectedProduct = product;
      this.showModal = true;
      document.body.style.overflow = "hidden"; // prevent background scroll
    },
    closeModal() {
      this.showModal = false;
      document.body.style.overflow = "auto";
    },
    addToCart(product) {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      const existing = cart.find((item) => item.id === product.id);

      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: Number(product.price),
          image: product.image_url || "https://via.placeholder.com/100",
          quantity: 1,
        });
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      window.dispatchEvent(new Event("storage"));
      alert(`✅ Added ${product.name} to cart!`);
    },
  },
};
</script>

<style scoped>
.home {
  padding: 40px;
  background-color: #f8fafc;
  min-height: 100vh;
  text-align: center;
}
h1 {
  font-size: 2rem;
  color: #1e293b;
  margin-bottom: 30px;
}
.loading,
.error {
  font-size: 1.2rem;
  color: #6b7280;
  margin-top: 20px;
}
.error {
  color: #dc2626;
}
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 25px;
}
.product-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}
.product-card img {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 10px;
  object-fit: contain;
  height: 150px;
}
.price {
  color: #059669;
  font-weight: bold;
  margin-bottom: 10px;
}
button {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}
button:hover {
  background-color: #2563eb;
}
.clickable {
  cursor: pointer;
  transition: color 0.2s;
}
.clickable:hover {
  color: #2563eb;
}

/* ===== MODAL STYLES ===== */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 23, 42, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(3px);
  animation: fadeIn 0.3s ease;
}
.modal-content {
  background: white;
  border-radius: 16px;
  padding: 30px;
  width: 90%;
  max-width: 500px;
  text-align: center;
  position: relative;
  animation: slideUp 0.3s ease;
}
.modal-image {
  width: 200px;
  height: 200px;
  object-fit: contain;
  border-radius: 12px;
  margin-bottom: 20px;
}
.modal-title {
  font-size: 1.4rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 10px;
}
.modal-description {
  color: #475569;
  font-size: 0.95rem;
  margin-bottom: 15px;
  line-height: 1.5;
}
.modal-price {
  color: #059669;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 20px;
}
.modal-cart-btn {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 12px 22px;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s;
}
.modal-cart-btn:hover {
  background-color: #2563eb;
}
.close-btn {
  position: absolute;
  top: 15px;
  right: 18px;
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #475569;
  cursor: pointer;
  transition: color 0.2s;
}
.close-btn:hover {
  color: #1e293b;
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
@keyframes slideUp {
  from {
    transform: translateY(30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
