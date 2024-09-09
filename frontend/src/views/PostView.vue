<script setup>
import Content from "@/components/Content.vue";
import Card from "@/components/Card.vue";
</script>

<template>
    <Content title="Listing of All Post" current="Posts">
        <Card>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td>B</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>B</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>B</td>
                        <td>C</td>
                    </tr>
                </tbody>
            </table>
        </Card>
    </Content>
</template>