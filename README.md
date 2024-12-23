## Project: Data-Stream-Processor-API

### Auther: Mahendra Kumar Mourya

## Project Setup Steps:

step1. Run git clone https://github.com/mahendramourya/Data-Stream-Processor-API.git
<br>
step2. git checkout mahendra
<br>
step2. configure database using .env.example file.
<br>
step3. Run project with php artisan serve command
<br>
step4. open postman
<br>
step5. test api 'http://127.0.0.1:8000/api/data-stream/analyze' in localhost server. with POST request
<br>

payload:
<br>
stream:AAABBBCCCAAABBBCCCAAABBBCCCAAABBBCCCAAABBBCCCAAABBBCCC
k:3
top:5
exclude[]:AAA
<br>
response:
<br>
{
    "status": true,
    "message": "Analysis Data",
    "data": {
        "AAB": 6,
        "ABB": 6,
        "BBB": 6,
        "BBC": 6,
        "BCC": 6
    }
}

