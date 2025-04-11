import React, { useState, useEffect } from "react";
import axios from "axios";
import "db.php";

function App() {
  const [tasks, setTasks] = useState([]);
  const [newTask, setNewTask] = useState("");

  // Fetch tasks from the backend
  const fetchTasks = async () => {
    try {
      const response = await axios.get("http://localhost/backend/api.php");
      setTasks(response.data);
    } catch (error) {
      console.error("Error fetching tasks:", error);
    }
  };

  // Load tasks on component mount
  useEffect(() => {
    fetchTasks();
  }, []);

  // Add a new task
  const handleAddTask = async (e) => {
    e.preventDefault();
    if (newTask.trim()) {
      try {
        await axios.post("http://localhost/backend/api.php", { task: newTask });
        setNewTask("");
        fetchTasks();
      } catch (error) {
        console.error("Error adding task:", error);
      }
    }
  };

  // Mark a task as complete
  const handleCompleteTask = async (id) => {
    try {
      await axios.put("http://localhost/backend/api.php", { id });
      fetchTasks();
    } catch (error) {
      console.error("Error completing task:", error);
    }
  };

  // Delete a task
  const handleDeleteTask = async (id) => {
    try {
      await axios.delete("http://localhost/backend/api.php", { data: { id } });
      fetchTasks();
    } catch (error) {
      console.error("Error deleting task:", error);
    }
  };

  // Render tasks using map
  const renderTasks = () => {
    return tasks.map((task) => (
      <li
        key={task.id}
        className={task.status}
      >
        <strong>{task.task}</strong>
        <div className="actions">
          {task.status !== "completed" && (
            <button onClick={() => handleCompleteTask(task.id)}>
              Complete
            </button>
          )}
          <button onClick={() => handleDeleteTask(task.id)}>Delete</button>
        </div>
      </li>
    ));
  };

  return (
    <div className="container">
      <h1>Todo App</h1>
      <form onSubmit={handleAddTask}>
        <input
          type="text"
          value={newTask}
          onChange={(e) => setNewTask(e.target.value)}
          placeholder="Add a new task"
          required
        />
        <button type="submit">Add Task</button>
      </form>

      <ul>{renderTasks()}</ul>
    </div>
  );
}

export default App;

// import React, { useState, useEffect } from "react";
// import axios from "axios";
// import "db.php";

// function App() {
//   const [tasks, setTasks] = useState([]);
//   const [newTask, setNewTask] = useState("");

//   // Fetch tasks from the backend
//   const fetchTasks = async () => {
//     try {
//       const response = await axios.get("http://localhost/backend/api.php");
//       setTasks(response.data);
//     } catch (error) {
//       console.error("Error fetching tasks:", error);
//     }
//   };

//   // Load tasks on component mount
//   useEffect(() => {
//     fetchTasks();
//   }, []);

//   // Add a new task
//   const handleAddTask = async (e) => {
//     e.preventDefault();
//     if (newTask.trim()) {
//       try {
//         await axios.post("http://localhost/backend/api.php", { task: newTask });
//         setNewTask("");
//         fetchTasks();
//       } catch (error) {
//         console.error("Error adding task:", error);
//       }
//     }
//   };

//   // Mark a task as complete
//   const handleCompleteTask = async (id) => {
//     try {
//       await axios.put("http://localhost/backend/api.php", { id });
//       fetchTasks();
//     } catch (error) {
//       console.error("Error completing task:", error);
//     }
//   };

//   // Delete a task
//   const handleDeleteTask = async (id) => {
//     try {
//       await axios.delete("http://localhost/backend/api.php", { data: { id } });
//       fetchTasks();
//     } catch (error) {
//       console.error("Error deleting task:", error);
//     }
//   };

//   // Render tasks using map
//   const renderTasks = () => {
//     return tasks.map((task) => (
//       <li
//         key={task.id}
//         className={task.status}
//       >
//         <strong>{task.task}</strong>
//         <div className="actions">
//           {task.status !== "completed" && (
//             <button onClick={() => handleCompleteTask(task.id)}>
//               Complete
//             </button>
//           )}
//           <button onClick={() => handleDeleteTask(task.id)}>Delete</button>
//         </div>
//       </li>
//     ));
//   };

//   return (
//     <div className="container">
//       <h1>Todo App</h1>
//       <form onSubmit={handleAddTask}>
//         <input
//           type="text"
//           value={newTask}
//           onChange={(e) => setNewTask(e.target.value)}
//           placeholder="Add a new task"
//           required
//         />
//         <button type="submit">Add Task</button>
//       </form>

//       <ul>{renderTasks()}</ul>
//     </div>
//   );
// }

// export default App;
