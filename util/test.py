import hashlib
from random import shuffle


def npa(name, passw, access):
    hashed = hashlib.sha256()
    hashed.update(bytes(passw, 'utf-8'))
    hashed = hashed.hexdigest()
    return f"('{name}', '{passw}', '{access}')"


names = ['alice', 'bob', 'charlie', 'doug', 'ernie']
passes = ['you', 'are', 'an', 'idiot', 'haha']
access = ['ADMIN', 'USER', 'USER', 'USER', 'USER']

shuffle(names)
shuffle(passes)
shuffle(access)

for vals in zip(names, passes, access):
    print(npa(*vals), end=', ')
