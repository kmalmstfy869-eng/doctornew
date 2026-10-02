<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" lang="ar">
<head>
<title><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light" />
<meta name="supported-color-schemes" content="light" />
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.header-table {
width: 100% !important;
}

.footer {
width: 100% !important;
}

.content-cell {
padding: 24px 18px !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
<?php echo $head ?? ''; ?>

</head>
<body dir="rtl" style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Tahoma', Arial, sans-serif; direction: rtl; text-align: right;">

<?php if(! empty($preheader)): ?>
<span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0; max-height: 0; max-width: 0; overflow: hidden; mso-hide: all; line-height: 0; font-size: 0;">
<?php echo new \Illuminate\Support\EncodedHtmlString($preheader); ?>

</span>
<?php endif; ?>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" dir="rtl">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<?php echo $header ?? ''; ?>


<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" dir="rtl">
<!-- Body content -->
<tr>
<td class="content-cell">
<?php echo Illuminate\Mail\Markdown::parse($slot); ?>


<?php echo $subcopy ?? ''; ?>

</td>
</tr>
</table>
</td>
</tr>

<?php echo $footer ?? ''; ?>

</table>
</td>
</tr>
</table>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/vendor/mail/html/layout.blade.php ENDPATH**/ ?>