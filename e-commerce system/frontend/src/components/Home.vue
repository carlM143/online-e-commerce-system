<template>
  <div class="home">
    <h1>🛍️ Featured Products</h1>

    <div v-if="loading" class="loading">Loading products...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <div v-else class="product-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <img :src="product.image_url" :alt="product.name" />
        <h3>{{ product.name }}</h3>
        <p class="price">${{ Number(product.price).toFixed(2) }}</p>
        <button @click="addToCart(product)">Add to Cart</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios"

export default {
  name: "Home",
  data() {
    return {
      products: [],
      loading: true,
      error: null,
    }
  },
  async created() {
    try {
      const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/products`)
      this.products = response.data
    } catch (err) {
      this.error = "Failed to load products. Please try again later."
      console.error("API Error:", err)
    } finally {
      this.loading = false
    }
  },
  methods: {
    addToCart(product) {
      const cart = JSON.parse(localStorage.getItem("cart")) || []
      const existing = cart.find((item) => item.id === product.id)

      if (existing) {
        existing.quantity += 1
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: Number(product.price),
          image: product.image_url || "https://via.placeholder.com/100",
          quantity: 1,
        })
      }

      localStorage.setItem("cart", JSON.stringify(cart))
      window.dispatchEvent(new Event("storage"))
      alert(`✅ Added ${product.name} to cart!`)
    },
  },
}
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
</style>
