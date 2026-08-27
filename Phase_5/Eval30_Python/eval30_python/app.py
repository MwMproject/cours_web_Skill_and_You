from flask import Flask, render_template, request
from database import Database

app = Flask(__name__)

db = Database()
db.create_table()

@app.route('/')
def accueil():
    return "Bonjour utilisateur anonyme"

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

    return render_template('login.html')

@app.route('/signup', methods=['GET', 'POST'])
def signup():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']
        password_confirm = request.form['password_confirm']

        if password == password_confirm:
            db.add_user(email, password)
            return "Utilisateur enregistré"
        else:
            return "les mots de passe ne sont pas identiques"
    return render_template('signup.html')