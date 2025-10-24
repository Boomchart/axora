<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6"><?php echo e(__('Webhook')); ?></h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-10 text-dark"><?php echo e(__('Webhooks are an important part of your payment integration. They allow')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('notify you about events that happen on your account, such as a charge or payment transaction. A webhook URL is an endpoint on your server where you can receive notifications about such events. When an event occurs, we\'ll make a POST request to that endpoint, with a JSON body containing the details about the event, including the type of event and the data associated with it')); ?>.</p>
            <h2 class="fw-bold fs-5"><?php echo e(__('Enabling webhooks')); ?></h2>
            <p class="mb-2 text-dark"><?php echo e(__('Here\'s how to set up a webhook on your')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('account')); ?>:</p>
            <ol class="fs-7 mb-10">
              <li><?php echo e(__('Log in to your dashboard and click on Settings')); ?></li>
              <li><?php echo e(__('Navigate to Webhooks to add your webhook URL & secret key')); ?></li>
            </ol>

            <h2 class="fw-bold fs-5"><?php echo e(__('Verifying webhook signatures')); ?></h2>
            <p class="mb-0 text-dark mb-10"><?php echo e(__('When enabling webhooks, you have to set a webhook secret. Since webhook URLs are publicly accessible, the webhook secret allows you to verify that incoming requests are from')); ?> <?php echo e($set->site_name); ?>. <?php echo e(__('You can specify any value as your secret hash, but we recommend something random. You should also store it as an environment variable on your server. You must specify a webhook secret, as we\'ll include it in our request to your webhook URL, in a header called Signature. In the webhook endpoint, check if the Signature header is present and that it matches the secret hash you set. If the header is missing, or the value doesn\'t match, you can discard the request, as it isn\'t from')); ?> <?php echo e($set->site_name); ?>.</p>

            <h2 class="fw-bold fs-5"><?php echo e(__('Responding to webhook requests')); ?></h2>
            <p class="mb-0 text-dark mb-10"><?php echo e(__('To acknowledge receipt of a webhook, your endpoint must return a 200 HTTP status code. Any other response codes, including 3xx codes, will be treated as a failure. We don\'t care about the response body or headers')); ?></p>

            <h2 class="fw-bold fs-5"><?php echo e(__('You may need to disable CSRF protection')); ?></h2>
            <p class="mb-0 text-dark mb-10"><?php echo e(__('Some web frameworks like Rails or Django, automatically check that every POST request contains a CSRF token. This is a useful security feature that protects you and your users from cross-site request forgery')); ?>.</p>

            <h2 class="fw-bold fs-5"><?php echo e(__('Example')); ?></h2>
            <p class="mb-2 text-dark"><?php echo e(__('Here are a few examples of implementing a webhook endpoint in php')); ?></p>
<pre class="rounded mb-10">
  <code class="language-php" data-lang="php">
  // <?php echo e(__('In a Laravel-like app')); ?>:
  Route::post('webhook', function (\Illuminate\Http\Request $request) {
      //check for the signature
      $secret = '12345';
      $signature = $request->header('webhook-secret');
      $sign_secret = hash_hmac('sha256', json_encode($request->all()), $secret);
      if (!$signature || ($signature !== $sign_secret)) {
          // This request isn't from <?php echo e($set->site_name); ?>; discard
          abort(401);
      }
      $payload = $request->all();
      // <?php echo e(__('It\'s a good idea to log all received events')); ?>.
      Log::info($payload);
      // <?php echo e(__('Do something (that doesn\'t take too long) with the payload')); ?>

      return response(200);
  });
  </code>
</pre>
            <h2 class="fw-bold fs-5"><?php echo e(__('Retries & Failure')); ?></h2>
            <p class="mb-10 text-dark"><?php echo e(__('In a case where')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('was unable to reach the URL, all the webhooks will be retried. Webhook URLs must respond with a status 200 OK or the request will be considered unsuccessful and retried')); ?>.</p>

            <h2 class="fw-bold fs-5"><?php echo e(__('Sample webhook format')); ?></h2>
            <p class="mb-3 text-dark"><?php echo e(__('The JSON payload below is a sample response of a webhook event that gets sent to your webhook URL. You should know that all webhook events across')); ?> <?php echo e($set->site_name); ?>, <?php echo e(__('payout, funding, payouts all follow the same payload format as shown below')); ?>.</p>
            <div class="table-responsive mb-10">
              <table class="table table-row-bordered table-flush align-middle gy-6">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold bg-lighten">
                  <tr>
                    <th class="text-left"><?php echo e(__('Fields')); ?></th>
                    <th class="text-left"><?php echo e(__('Descriptions')); ?></th>
                  </tr>
                </thead>
                <tbody class="fs-7 fw-bold text-gray-700">
                  <tr>
                    <td class="text-left"><?php echo e(__('event')); ?></td>
                    <td class="text-left"><?php echo e(__('The name or type of webhook event that gets sent eg; charge')); ?>.</td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo e(__('data')); ?></td>
                    <td class="text-left"><?php echo e(__('The payload of the webhook event object that gets sent')); ?>.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <h2 class="fw-bold fs-5"><?php echo e(__('Webhook events')); ?></h2>
            <ol class="fs-7 mb-10">
              <li>issued</li>
              <li>redemption</li>
            </ol>
<pre class="rounded mb-10">
<code class="language-json" data-lang="json">
{
  "event": "issued",
  "data": {
    "id": "e1a88d14-f8a7-4f10-bced-1da043ca890c",
    "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
    "name": "Farmfoods",
    "amount": 25,
    "currency": "GBP",
    "status": "success",
    "card_code": "RJNI-0PLB-VQL3-1ZW6",
    "card_url": null,
    "expires": "2026-07-06T17:14:58.000000Z"
  }
}
</code>
</pre>
<pre class="rounded mb-10">
<code class="language-json" data-lang="json">
{
  "event": "redemption",
  "data": {
    "id": "e1a88d14-f8a7-4f10-bced-1da043ca890c",
    "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
    "name": "Farmfoods",
    "processed_amount": 2,
    "balance": 21,
    "card_code": "UDCV-SHXV-XPAV-41FG",
    "card_url": null,
    "expires": "2026-07-06T17:14:58.000000Z"
  }
}
</code>
</pre>
            <h2 class="fw-bold fs-5 mb-3"><?php echo e(__('Best practices')); ?></h2>
            <h4 class="fw-bold fs-7"><?php echo e(__('Don\'t rely solely on webhooks')); ?></h4>
            <p class="mb-10 text-dark"><?php echo e(__('Have a backup strategy in place, in case your webhook endpoint fails. For instance, if your webhook endpoint is throwing server errors, you won\'t know about any new customer payments because webhook requests will fail')); ?>.</p>
            <h4 class="fw-bold fs-7"><?php echo e(__('Respond quickly')); ?></h4>
            <p class="mb-3 text-dark"><?php echo e(__('Your webhook endpoint needs to respond within a certain time limit, or we\'ll consider it a failure and try again. Avoid doing long-running tasks or network calls in your webhook endpoint so you don\'t hit the timeout. If your framework supports it, you can have your webhook endpoint immediately return a 200 status code, and then perform the rest of its duties; otherwise, you should dispatch any long-running tasks to a job queue, and then respond')); ?>.</p>
        </div>
    </div>
</div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('developer.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/webhook.blade.php ENDPATH**/ ?>