from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def accueil():
    return "Bonjour utilisateur anonyme"

@app.route('/login', methods=['GET', 'POST'])
def login():
    return render_template('login.html')