<template>
    <div>...</div>
</template>
<script setup>
import router from "../router";

let searchParams = new URLSearchParams(window.location.search);
let code = searchParams.get("code");

if (code === null) {
    throw new Error(
        "code query param must be present when entering /callback path"
    );
}

useOauthProviderCode(code);

async function useOauthProviderCode(code) {
    try {
        const response = await fetch(`/api/auth/github/callback?code=${code}`, {
            method: "GET",
            headers: {
                Accept: "application/json",
            },
        });

        if (!response.ok) {
            throw new Error("Network response was not ok");
        }

        const data = await response.json();

        const token = data.token;
        localStorage.setItem("authToken", token);

        router.push("/dashboard");
    } catch (error) {
        console.error("Error fetching data:", error);
        router.push("/auth");
    }
}
</script>
