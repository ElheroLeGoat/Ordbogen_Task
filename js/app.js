const Vue = window.Vue;
const axios = window.axios;

new Vue({
	el: ".login_form",
	
	data:
	{
		configs:
		{
			loginheader: 'Login',
			registerform: false,
			errors: []
		},
		form:
		{
			username: '',
			password: '',
			repeat: null,
			email: null,
		},
		tooltips:
		{
			username: '',
			password: ''
		}
	},
	
	methods : 
	{
		switchForm: function(e)
		{
			// Switch to login form
			if (this.configs.registerform)
			{
				this.tooltips.username = '';
				this.tooltips.password = '';
				this.configs.loginheader = 'Login';
				this.configs.errors = [];
			}
			// Switch to register form
			else
			{
				this.tooltips.username = 'username must be between 5 and 64 characters';
				this.tooltips.password = 'password must be between 8 and 64 characters. \n contain numbers upper and lowercase letter \n and have atleast one of the following characters: !@#$%*';
				this.configs.loginheader = 'Register';
				this.configs.errors = [];
			}
			
			this.configs.registerform = !this.configs.registerform;
			
			
		},
		exec: function(e)
		{
			this.form.errors = [];
			if (!this.configs.registerform)
			{
				reg = this.prepare(type='login');
			}
			else
			{			
				reg = this.prepare(type='register');
			}
									
			if (!reg.success)
			{
				alert(this.configs.errors.join('\n'));
				return;
			}
			
			axios.post('index.php', reg.data)
			.then((res) =>
			{	
				console.log(res);
				if (res.data.success !== undefined && res.data.success == false)
				{
					if (typeof(res.data.reason) == 'object')
					{
						alert(res.data.reason.join('\n'));
					}
					else
					{
						alert(res.data.reason);
					}
				}
				else
				{
					if (this.configs.registerform)
					{
						this.configs.registerform = false;
						this.configs.loginheader = 'Login';
						this.configs.errors = []
						this.form.username = '';
						this.form.password = '';
						this.form.repeat = '';
						this.form.email = '';
						alert("Registration successfull, you can now login.");
					}
					else
					{
						location.reload();
					}
				}
			});
		},
		prepare: function(type)
		{
			returnval =  {data: {username: this.form.username, password: this.form.password, form: this.configs.loginheader}}
			
			if (type == 'login')
			{
				returnval.success = this.checkLogin();
			}
			else
			{
				returnval.success = this.checkRegister();
				returnval.data.email = this.form.email;
			}
			
			return returnval;
		},
		checkRegister: function(e)
		{
 			if (this.checkLogin() && this.form.email && this.form.password == this.form.repeat)
			{
				return true;
			}
			if (!this.form.email)
			{
				this.configs.errors.push("Email is required");
			}
			if (this.form.password !== this.form.repeat)
			{
				this.configs.errors.push("Passwords doesn't match");
			}
			
			return false;
		},
		checkLogin: function(e)
		{	
			if (this.form.username && this.form.password)
			{
				return true;
			}
			if (!this.form.username)
			{
				this.configs.errors.push("Username is required");
			}
			if (!this.form.password)
			{
				this.configs.errors.push("Password is required");
			}
			return false;
		}
	}
});