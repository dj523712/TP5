<template>
  <div>
    <ul><input v-model="username" placeholder="用户名"></ul>
    <ul><input v-model="password" placeholder="密码"></ul>
    <button v-on:click="login()">登录</button>
  </div>
</template>

<script>
  export default {
    name: 'login',
    data () {
      return {
        username: '', //  用户名
        password: '', //  密码
        login () {
          if (this.username !== '' && this.password !== '') {
            console.log(1111)
//          this.$router.go('http://www.baidu.com')
          } else {
            alert('账号或密码不能为空！')// 我们判断下账号密码是否为空
          }
        }
      }
    }
  }
</script>

<style>
  ul {
    text-align: center;
  }

</style>