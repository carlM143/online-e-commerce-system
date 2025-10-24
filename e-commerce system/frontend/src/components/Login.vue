<template>
  <div class="login-container">
    <div class="login-card">
      <!-- Logo/Header -->
      <div class="header">
        <div class="logo">
          <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
        <h1>TechStore</h1>
        <p class="subtitle">
          {{ isSignUp ? 'Create your account' : 'Welcome back!' }}
        </p>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="error-message">
        {{ error }}
      </div>

      <!-- Login Form -->
      <form v-if="!isSignUp" @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <input
              v-model="loginForm.email"
              type="email"
              placeholder="your@email.com"
              class="form-input"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <input
              v-model="loginForm.password"
              type="password"
              placeholder="••••••••"
              class="form-input"
            />
          </div>
        </div>

        <button type="submit" class="btn-primary">
          Sign In
        </button>
      </form>

      <!-- Sign Up Form -->
      <form v-else @submit.prevent="handleSignUp">
        <div class="form-group">
          <label>Full Name</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <input
              v-model="signUpForm.name"
              type="text"
              placeholder="John Doe"
              class="form-input"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <input
              v-model="signUpForm.email"
              type="email"
              placeholder="your@email.com"
              class="form-input"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <input
              v-model="signUpForm.password"
              type="password"
              placeholder="••••••••"
              class="form-input"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Confirm Password</label>
          <div class="input-wrapper">
            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <input
              v-model="signUpForm.confirmPassword"
              type="password"
              placeholder="••••••••"
              class="form-input"
            />
          </div>
        </div>

        <button type="submit" class="btn-primary">
          Create Account
        </button>
      </form>

      <!-- Toggle between Login/SignUp -->
      <div class="toggle-form">
        <button @click="toggleForm" class="link-button">
          {{ isSignUp ? 'Already have an account? Sign In' : "Don't have an account? Sign Up" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const isSignUp = ref(false);
const error = ref('');

const loginForm = ref({
  email: '',
  password: ''
});

const signUpForm = ref({
  name: '',
  email: '',
  password: '',
  confirmPassword: ''
});

const handleLogin = async () => {
  error.value = '';
  
  if (!loginForm.value.email || !loginForm.value.password) {
    error.value = 'Please fill in all fields';
    return;
  }
  
  try {
    // TODO: Replace with actual API call to your authentication microservice
    // const response = await fetch('http://localhost:3001/api/auth/login', {
    //   method: 'POST',
    //   headers: { 'Content-Type': 'application/json' },
    //   body: JSON.stringify(loginForm.value)
    // });
    // const data = await response.json();
    
    // Mock login for now
    const user = {
      name: loginForm.value.email.split('@')[0],
      email: loginForm.value.email,
      token: 'mock-jwt-token'
    };
    
    // Store user data
    localStorage.setItem('user', JSON.stringify(user));
    
    // Redirect to products page
    router.push('/products');
    
  } catch (err) {
    error.value = 'Login failed. Please try again.';
    console.error('Login error:', err);
  }
};

const handleSignUp = async () => {
  error.value = '';
  
  if (!signUpForm.value.name || !signUpForm.value.email || 
      !signUpForm.value.password || !signUpForm.value.confirmPassword) {
    error.value = 'Please fill in all fields';
    return;
  }
  
  if (signUpForm.value.password !== signUpForm.value.confirmPassword) {
    error.value = 'Passwords do not match';
    return;
  }
  
  if (signUpForm.value.password.length < 6) {
    error.value = 'Password must be at least 6 characters';
    return;
  }
  
  try {
    // TODO: Replace with actual API call to your authentication microservice
    // const response = await fetch('http://localhost:3001/api/auth/register', {
    //   method: 'POST',
    //   headers: { 'Content-Type': 'application/json' },
    //   body: JSON.stringify({
    //     name: signUpForm.value.name,
    //     email: signUpForm.value.email,
    //     password: signUpForm.value.password
    //   })
    // });
    // const data = await response.json();
    
    // Mock sign up for now
    const user = {
      name: signUpForm.value.name,
      email: signUpForm.value.email,
      token: 'mock-jwt-token'
    };
    
    localStorage.setItem('user', JSON.stringify(user));
    router.push('/products');
    
  } catch (err) {
    error.value = 'Registration failed. Please try again.';
    console.error('Sign up error:', err);
  }
};

const toggleForm = () => {
  isSignUp.value = !isSignUp.value;
  error.value = '';
};
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.login-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  width: 100%;
  max-width: 440px;
  padding: 40px;
}

.header {
  text-align: center;
  margin-bottom: 32px;
}

.logo {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 64px;
  height: 64px;
  background: #2563eb;
  border-radius: 50%;
  margin-bottom: 16px;
}

.icon {
  width: 32px;
  height: 32px;
  color: white;
}

h1 {
  font-size: 28px;
  font-weight: bold;
  color: #1f2937;
  margin: 0 0 8px 0;
}

.subtitle {
  color: #6b7280;
  font-size: 16px;
  margin: 0;
}

.error-message {
  background: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
  padding: 12px 16px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 14px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.input-wrapper {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 12px;
  top: 12px;
  width: 20px;
  height: 20px;
  color: #9ca3af;
}

.form-input {
  width: 100%;
  padding: 12px 12px 12px 40px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s;
  box-sizing: border-box;
}

.form-input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn-primary {
  width: 100%;
  background: #2563eb;
  color: white;
  padding: 14px;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  margin-top: 8px;
}

.btn-primary:hover {
  background: #1d4ed8;
}

.toggle-form {
  margin-top: 24px;
  text-align: center;
}

.link-button {
  background: none;
  border: none;
  color: #2563eb;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  padding: 0;
}

.link-button:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

@media (max-width: 480px) {
  .login-card {
    padding: 30px 20px;
  }
  
  h1 {
    font-size: 24px;
  }
}
</style>