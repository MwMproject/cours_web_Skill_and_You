from flask import Flask, render_template, request, redirect
from database import Database

connected_user = []

app = Flask(__name__)

db = Database()
db.create_table()

@app.route('/')
def accueil():
    return render_template('home.html', connected_user=connected_user)



@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

        user = db.get_user_by_email(email, password)

        if user:
            connected_user.clear()
            connected_user.append(email)
            return render_template(
                'login.html',
                connected_user=connected_user,
                success=True
            )
        else:
            return render_template(
                'login.html',
                connected_user=connected_user,
                error="Email ou mot de passe incorrect"
            )

    return render_template('login.html', connected_user=connected_user)

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
            return render_template(
                'signup.html',
                connected_user=connected_user,
                success=True
            )
        else:
            return render_template(
                'signup.html',
                connected_user=connected_user,
                error="Les mots de passe ne sont pas identiques"
            )
    return render_template('signup.html', connected_user=connected_user)