from flask import Flask

app = Flask(__name__)

@app.route('/')
def accueil():
    return "Bonjour utilisateur anonyme"

@app.route('/login', methods=['GET', 'POST'])
def login():
    return "Page de connexion"