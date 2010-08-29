<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>RegHash Example Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<h2>Register Now!</h2>

<strong>&#123;exp:reghash:link&#125;:</strong> {exp:reghash:link}<br />
<strong>&#123;exp:reghash:hash&#125;:</strong> {exp:reghash:hash}
<br /><br />
<hr />

{if logged_in}
	<p>You've already registered and logged in.</p>
{/if}

{if logged_out}
  
	{if segment_3 != ""}
		{if segment_3 != "{exp:reghash:hash}"}

			<h3>Tomfoolery!</h3><br />
			<a href="{exp:reghash:link}">Try again</a>

		{if:else}
			{!-- Example register form from the Solspace User module --}
			{exp:user:register form_name="members_register" form_id="registerform" return="members/thank-you"}
				<label for="username">Username <span class="req">*</span></label>
				<input type="text" class="medium" name="username" id="username" value="" maxlength="32" />
				<br />
				<label for="screen_name">Screen Name <span class="req">*</span></label>
				<input type="text" class="medium" name="screen_name" id="screen_name" value="" />
				<br />
				<label for="email">Email <span class="req">*</span></label>
				<input type="text" name="email" id="email" value="" />
				<br />
				<label for="password">Password <span class="req">*</span></label>
				<input class="medium" type="password" name="password" id="password" value="" />
				<br />
				<label for="password_confirm">Confirm Password <span class="req">*</span></label>
				<input class="medium" type="password" name="password_confirm" id="password_confirm" value="" />
				<br />
				<button class="btn-submit" type="submit" name="submit"><span>Join</span></button>
				<input class="hidden" type="hidden" name="accept_terms" value="y" />
			{/exp:user:register}

		{/if}
	{/if}

	{if segment_3 == ""}
		<h3>Sorry! Segment_3 is blank!</h3>
		<a href="{exp:reghash:link}">Try again</a>
	{/if}


{/if} {!-- logged_out check --}

</body>
</html>