@extends('developer.menu')

@section('content')
    <h1>Errors</h1>
    <p class="lead-text">
        {{$set->site_name}} uses conventional HTTP response codes to indicate the success or failure of an API request. Codes in the 2xx range indicate success, codes in the 4xx range indicate an error with the provided information, and codes in the 5xx range indicate a server error.
    </p>

    <h2 id="http-status-codes">HTTP Status Codes</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Status</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><code>200</code></td>
            <td>OK</td>
            <td>The request was successful</td>
        </tr>
        <tr>
            <td><code>201</code></td>
            <td>Created</td>
            <td>The resource was successfully created</td>
        </tr>
        <tr>
            <td><code>400</code></td>
            <td>Bad Request</td>
            <td>The request was malformed or invalid</td>
        </tr>
        <tr>
            <td><code>401</code></td>
            <td>Unauthorized</td>
            <td>Authentication failed or API key is invalid</td>
        </tr>
        <tr>
            <td><code>403</code></td>
            <td>Forbidden</td>
            <td>You don't have permission to access this resource</td>
        </tr>
        <tr>
            <td><code>404</code></td>
            <td>Not Found</td>
            <td>The requested resource doesn't exist</td>
        </tr>
        <tr>
            <td><code>422</code></td>
            <td>Unprocessable Entity</td>
            <td>Validation errors occurred</td>
        </tr>
        <tr>
            <td><code>429</code></td>
            <td>Too Many Requests</td>
            <td>Rate limit exceeded</td>
        </tr>
        <tr>
            <td><code>500</code></td>
            <td>Internal Server Error</td>
            <td>Something went wrong on our end</td>
        </tr>
        <tr>
            <td><code>503</code></td>
            <td>Service Unavailable</td>
            <td>The service is temporarily unavailable</td>
        </tr>
        </tbody>
    </table>

    <h2 id="error-response-format">Error Response Format</h2>
    <p>
        All errors return a JSON object with an <code>error</code> object containing details about what went wrong:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Error Response Structure</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
    "status": "failed",
    "message": "Insufficient funds",
    "data": "null"
}</code></pre>
    </div>

    <h2 id="handling-errors">Handling Errors</h2>
    <p>
        Here's an example of how to handle errors in your application:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP Error Handling</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">try {
    $response = $client->post('/gift-cards', [
        'json' => $data
    ]);

    $result = json_decode($response->getBody(), true);
    // Process successful response

} catch (\GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    $statusCode = $response->getStatusCode();
    $error = json_decode($response->getBody(), true);

    if ($statusCode === 422) {
        // Handle validation errors
        foreach ($error['error']['details'] as $detail) {
            echo "Field: {$detail['field']}, Error: {$detail['message']}";
        }
    } elseif ($statusCode === 401) {
        // Handle authentication error
        echo "Authentication failed: " . $error['error']['message'];
    } else {
        // Handle other errors
        echo "Error: " . $error['error']['message'];
    }
}</code></pre>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Always check HTTP status codes before parsing responses</li>
            <li>Implement retry logic for 5xx errors with exponential backoff</li>
            <li>Log errors for debugging and monitoring</li>
            <li>Display user-friendly error messages to end users</li>
            <li>Handle rate limit errors by implementing backoff strategies</li>
            <li>Monitor error rates in production</li>
        </ul>
    </div>
@endsection