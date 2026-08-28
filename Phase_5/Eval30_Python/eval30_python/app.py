from flask import Flask, render_template, request, redirect
from database import Database

connected_user = []

app = Flask(__name__)

db = Database()
db.create_table()

@app.route('/')
def accueil():
    if connected_user:
        return f"Bonjour {connected_user[0]}"
    else:
        return "Bonjour utilisateur anonyme"



@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

        user = db.get_user_by_email(email, password)

        if user:
            connected_user.append(email)
            return "Connexion réussie"
        else:
            return "Email ou mot de passe incorrect"

    return render_template('login.html')

@app.route('/logout')
def logout():
    connected_user.clear()
    return redirect('/')



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