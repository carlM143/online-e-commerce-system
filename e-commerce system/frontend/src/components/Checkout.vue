<template>
  <div class="checkout-page">
    <h2>💳 Checkout</h2>

    <form @submit.prevent="placeOrder" class="checkout-form">
      <label>Email Address:</label>
      <input type="email" v-model="email" required />

      <h3>Order Summary:</h3>
      <ul>
        <li v-for="(item, index) in cart" :key="index">
          {{ item.name }} - ${{ item.price.toFixed(2) }} × {{ item.quantity }}
        </li>
      </ul>

      <p><strong>Total:</strong> ${{ cartTotal.toFixed(2) }}</p>

      <button type="submit" class="submit-btn" :disabled="loading">
        {{ loading ? "Processing..." : "Place Order" }}
      </button>

      <p v-if="message" class="message">{{ message }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const message = ref('')
const loading = ref(false)

// Load cart from localStorage
const cart = ref(JSON.parse(localStorage.getItem('cart')) || [])

const cartTotal = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

// Place order to backend
const placeOrder = async () => {
  try {
    loading.value = true
    const payload = {
      email: email.value,
      cart: cart.value,
      total: cartTotal.value,
    }

    const res = await axios.post('http://localhost:8080/api/checkout', payload)
    message.value = res.data.message

    // Clear cart after success
    localStorage.removeItem('cart')
    setTimeout(() => router.push('/'), 2000)
  } catch (err) {
    console.error(err)
    message.value = '❌ Failed to place order.'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.checkout-page {
  padding: 40px;
  background: #f8fafc;
  min-height: 100vh;
}
.checkout-form {
  max-width: 500px;
  margin: 0 auto;
  background: white;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
}
input {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
}
.submit-btn {
  background: #10b981;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
}
.submit-btn:hover {
  background: #059669;
}
.message {
  margin-top: 15px;
  color: #2563eb;
}
</style>
