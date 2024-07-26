import React, { useState, useEffect } from 'react';
import axios from 'axios';

const RollNoApp = () => {
    const [data, setData] = useState([]);

    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost/get_data.php');
            setData(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    const generateRollNumbers = async () => {
        try {
            await axios.get('http://localhost/generate_rollno.php');
            fetchData(); // Refresh data after generating roll numbers
        } catch (error) {
            console.error('Error generating roll numbers:', error);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    return (
        <div>
            <button onClick={generateRollNumbers}>Generate Roll Numbers</button>
            <table>
                <thead>
                    <tr>
                        <th>Semester</th>
                        <th>Branch</th>
                        <th>Admission Year</th>
                        <th>Serial Number</th>
                        <th>Roll Number</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((item, index) => (
                        <tr key={index}>
                            <td>{item.sem}</td>
                            <td>{item.branch}</td>
                            <td>{item.ad_year}</td>
                            <td>{item.srno}</td>
                            <td>{item.rollno}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default RollNoApp;
