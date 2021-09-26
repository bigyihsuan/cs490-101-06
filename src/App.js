import React, { useState } from 'react';
import LoginForm from './components/LoginForm';
function App() {
  
    const adminUser = {   
      name: "admin",
      password: "1234"
    }
    
    const userOne = {   
      name: "user",
      password: "1234"
    }

    const [user, setUser] = useState({name:""});
    const [error, setError] = useState("");

    const Login = details => {
      console.log(details);
      if (details.name == adminUser.name && details.password == adminUser.password){
        console.log("Logged In Admin");
        setUser({
          name: details.name
        });
      }
      else if(details.name == userOne.name && details.password == userOne.password){
        console.log("Logged In UserOne");
        setUser({
          name: details.name
        });
      }
      else{
        console.log("Do not match");
        setError("Failed Login");
      }
    }

    const Logout = () => {
      console.log("Logout");
      setUser({name: "", password: ""});
    }
  
  
  
  
  
  
  
  
   return (
    <div className="App">
      
      {(user.name != "") ? (
        <div className = "Welcome">
          <h2>Welcome, <span>{user.name}</span></h2>
          <button onClick = {Logout}>Logout</button>
        </div>  
      ):(
        <LoginForm Login={Login} error = {error}/>
      )}
    </div>
   );
}

export default App;
