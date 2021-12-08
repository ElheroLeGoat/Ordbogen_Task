const Vue = window.Vue;
Vue.use(window.VeeValidate);

new Vue({
	el: "#login_form",
	data: {
		form: {
			username: Null,
			password: Null
		}
	}
	methods: {
		login: function(e)
		{
			this.checkLogin();
			
			
			e.preventDefault();
		}
		checkLogin: function(e) {
			if (this.username && this.password)
			{
				return true;
			}
			
			this.errors = [];
			
			if (!this.username)
			{
				this.errors.push("Please enter your username");
			}
			if (!this.password)
			{
				this.errors.push("Please enter your password");
			}
		}
	}
})