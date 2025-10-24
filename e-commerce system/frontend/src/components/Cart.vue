<template>
  <div class="cart-page">
    <h2>🛒 Your Shopping Cart</h2>

    <div v-if="cart.length === 0" class="empty-cart">
      <p>Your cart is empty 😢</p>
      <router-link to="/" class="back-btn">Go Back Shopping</router-link>
    </div>

    <div v-else class="cart-container">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in cart" :key="index">
            <td class="product-cell">
              <img :src="item.image" alt="Product" />
              <span>{{ item.name }}</span>
            </td>
            <td>${{ Number(item.price).toFixed(2) }}</td>
            <td>
              <input
                type="number"
                min="1"
                v-model.number="item.quantity"
                @change="saveCart"
              />
            </td>
            <td>${{ (Number(item.price) * item.quantity).toFixed(2) }}</td>
            <td>
              <button class="remove-btn" @click="removeItem(index)">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="cart-summary">
        <h3>Total: <span>${{ cartTotal.toFixed(2) }}</span></h3>
        <button class="checkout-btn" @click="checkout">
          Proceed to Checkout
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()
const cart = ref(JSON.parse(localStorage.getItem("cart")) || [])

cart.value = cart.value.map(item => ({
  ...item,
  price: Number(item.price) || 0,
  quantity: Number(item.quantity) || 1,
}))

const cartTotal = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const saveCart = () => {
  localStorage.setItem("cart", JSON.stringify(cart.value))
  window.dispatchEvent(new Event("storage"))
}

const removeItem = (index) => {
  cart.value.splice(index, 1)
  saveCart()
}

const checkout = () => {
  router.push("/checkout")
}
</script>

<style scoped>
.cart-page {
  padding: 40px;
  background: #f8fafc;
  min-height: 100vh;
}
h2 {
  font-size: 1.8rem;
  color: #1e293b;
  margin-bottom: 25px;
}
.empty-cart {
  text-align: center;
  margin-top: 60px;
  color: #64748b;
}
.back-btn {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 18px;
  background-color: #3b82f6;
  color: white;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.3s;
}
.back-btn:hover {
  background-color: #2563eb;
}
.cart-container {
  background: white;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  border-bottom: 1px solid #e2e8f0;
  text-align: left;
}
.product-cell {
  display: flex;
  align-items: center;
  gap: 15px;
}
.product-cell img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
}
input[type="number"] {
  width: 60px;
  text-align: center;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  padding: 6px;
}
.remove-btn {
  background: transparent;
  border: none;
  color: #ef4444;
  font-size: 1rem;
  cursor: pointer;
}
.remove-btn:hover {
  color: #dc2626;
}
.cart-summary {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 25px;
}
.cart-summary h3 {
  color: #1e293b;
}
.cart-summary span {
  color: #059669;
}
.checkout-btn {
  background: #10b981;
  color: white;
  padding: 12px 25px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s;
}
.checkout-btn:hover {
  background: #059669;
}
</style>
