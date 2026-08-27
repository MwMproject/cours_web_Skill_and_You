from flask import Flask, render_template, request

app = Flask(__name__)

@app.route('/')
def accueil():
    return "Bonjour utilisateur anonyme"

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

    return render_template('login.html')