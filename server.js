import express from 'express';
import axios from 'axios';
import dotenv from 'dotenv';

// Load environment variables from .env file
dotenv.config();

const app = express();
const port = 3000;

// Get your OpenAI API Key from environment variable
// const OPENAI_API_KEY = "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";
const {
    GoogleGenerativeAI,
    HarmCategory,
    HarmBlockThreshold,
} = require("@google/generative-ai");

const apiKey = process.env.GEMINI_API_KEY;
const genAI = new GoogleGenerativeAI(apiKey);

const model = genAI.getGenerativeModel({ model: "gemini-2.0-flash" });

// Middleware
app.use(express.json());  // Built-in body parser in Express v4.16+

app.get("/", (req, res) => {
    res.send("Welcome to the chatbot server!");
});


// POST route to handle user input and return LLM response
app.post("/chatbot", async (req, res) => {
    try {
        const userMessage = req.body.message;

        if (!userMessage) {
            return res.status(400).json({ error: "Message is required" });
        }

        // Send the user input to OpenAI's GPT-3 or GPT-4
        /* const openaiResponse = await axios.post(
            "https://api.openai.com/v1/chat/completions",  // Correct endpoint for chat completions
            {
                model: "o3-mini",  // Use valid model like "gpt-4" or "gpt-3.5-turbo"
                messages: [{ role: "user", content: userMessage }],
                max_tokens: 200,  // Adjust token limit based on your needs
                temperature: 0.5,
            },
            {
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${OPENAI_API_KEY}`,
                },
                timeout: 5000,  // Timeout after 5 seconds
            }
        ); */

        // Check for errors in the response
        /* if (openaiResponse.data.error) {
            console.error("Error from OpenAI:", openaiResponse.data.error);
            return res.status(500).json({ error: "OpenAI API error" });
        } */

        // Get the response text from OpenAI
        // const llmReply = openaiResponse.data.choices ? openaiResponse.data.choices[0].message.content.trim() : "No response from LLM.";

        // Send back the response to the client
        // res.json({ reply: llmReply });

        const result = await model.generateContent(userMessage);

        res.json({
            reply: result.response.text()
        })
    } catch (error) {
        console.error("Error during API request:", error.response ? error.response.data : error.message);
        res.status(500).json({ error: "An error occurred with the LLM API" });
    }
});
// Start the server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
