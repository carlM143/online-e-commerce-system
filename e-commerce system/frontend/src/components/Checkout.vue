<template>
  <div class="checkout-container">
    <button class="back-btn" @click="$router.push('/cart')">← Back</button>

    <div class="section">
      <h3>Delivery Options</h3>
      <div class="option">
        <input type="radio" id="delivery" value="delivery" v-model="deliveryOption" />
        <label for="delivery">Get it delivered in only 30 minutes</label>
      </div>
      <div class="option">
        <input type="radio" id="pickup" value="pickup" v-model="deliveryOption" />
        <label for="pickup">Pickup available in 3 stores near you</label>
      </div>
    </div>

    <div class="section">
      <h3>Shipping Address</h3>
      <input type="text" v-model="address" placeholder="Enter your shipping address" class="address-input" />
    </div>

    <div class="section">
      <h3>Payment Information</h3>
      <div class="payment-methods">
        <button :class="{ active: paymentMethod === 'paypal' }" @click="paymentMethod = 'paypal'">
          <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal" class="payment-logo" /> PayPal
        </button>
        <button :class="{ active: paymentMethod === 'stripe' }" @click="paymentMethod = 'stripe'">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.png/512px-Stripe_Logo%2C_revised_2016.png" alt="Stripe" class="payment-logo" /> Stripe
        </button>
        <button :class="{ active: paymentMethod === 'cod' }" @click="paymentMethod = 'cod'">
          <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="COD" class="payment-logo" /> Cash on Delivery
        </button>
      </div>

      <div v-if="paymentMethod === 'stripe'" class="card-form">
        <input type="text" placeholder="Name on card" v-model="card.name" />
        <input type="text" placeholder="Card number" v-model="card.number" maxlength="19" />
        <div class="row">
          <input type="text" placeholder="MM/YY" v-model="card.expiry" maxlength="5" />
          <input type="text" placeholder="CVV" v-model="card.cvv" maxlength="3" />
        </div>
      </div>
    </div>

    <div class="summary">
      <h3>Order Summary</h3>
      <ul>
        <li v-for="item in cart" :key="item.id" class="summary-item">
          <img :src="item.image" alt="Product" />
          <div class="item-info">
            <p>{{ item.name }} (x{{ item.quantity }})</p>
            <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
          </div>
        </li>
      </ul>
      <p>Delivery: <span>${{ deliveryCost.toFixed(2) }}</span></p>
      <p>Tax: <span>${{ tax.toFixed(2) }}</span></p>
      <h4>Total: <span>${{ total.toFixed(2) }}</span></h4>

      <button class="confirm-btn" @click="confirmPayment">
        Confirm Payment ${{ total.toFixed(2) }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Checkout",
  data() {
    return {
      deliveryOption: "delivery",
      address: "",
      paymentMethod: "paypal",
      card: { name: "", number: "", expiry: "", cvv: "" },
      deliveryCost: 4.99,
      tax: 0,
      cart: [],
    }
  },
  computed: {
    subtotal() {
      return this.cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
    },
    total() {
      return this.subtotal + this.deliveryCost + this.tax
    },
  },
  mounted() {
    const savedCart = JSON.parse(localStorage.getItem("cart")) || []
    this.cart = savedCart
    this.tax = this.subtotal * 0.05
  },
  methods: {
    confirmPayment() {
      if (!this.address) {
        alert("Please enter your shipping address.")
        return
      }

      const message = {
        paypal: `Redirecting to PayPal for payment of $${this.total.toFixed(2)} 💰`,
        stripe: `Processing Stripe payment of $${this.total.toFixed(2)} 💳`,
        cod: `Order confirmed! Please pay $${this.total.toFixed(2)} in cash upon delivery 💵`,
      }[this.paymentMethod]

      alert(message)
      localStorage.removeItem("cart")
      this.$router.push("/")
    },
  },
}
</script>

<style scoped>
.checkout-container {
  max-width: 900px;
  margin: 30px auto;
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
.back-btn {
  background: none;
  border: none;
  color: #3b82f6;
  font-size: 1rem;
  margin-bottom: 10px;
  cursor: pointer;
}
.section { margin-bottom: 25px; }
.address-input {
  width: 100%; padding: 10px; border-radius: 8px;
  border: 1px solid #ccc; margin-top: 8px;
}
.payment-methods {
  display: flex; gap: 20px; margin-bottom: 20px;
  justify-content: center; flex-wrap: wrap;
}
.payment-methods button {
  display: flex; align-items: center; justify-content: center;
  gap: 10px; padding: 18px 30px; border: 2px solid #ccc;
  border-radius: 12px; background: white; cursor: pointer;
  transition: all 0.25s ease; font-size: 1.1rem; min-width: 200px;
}
.payment-methods button.active {
  background: #3b82f6; color: white; border-color: #3b82f6;
}
.payment-logo { width: 28px; height: auto; }
.summary { background: #f9fafb; padding: 20px; border-radius: 10px; }
.summary-item {
  display: flex; align-items: center; gap: 12px; margin-bottom: 10px;
}
.summary-item img {
  width: 50px; height: 50px; object-fit: cover; border-radius: 6px;
}
.item-info {
  display: flex; justify-content: space-between; width: 100%;
}
.confirm-btn {
  background: #3b82f6; color: white; border: none;
  width: 100%; padding: 14px; border-radius: 8px;
  margin-top: 15px; font-size: 1.1rem; cursor: pointer;
}
.confirm-btn:hover { background: #2563eb; }
</style>
