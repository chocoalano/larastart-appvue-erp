<template>
    <v-container>
        <v-row>
            <v-col col=12 md=4 sm=12>
                <v-card>
                    <v-card-title>text</v-card-title>
                    <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam veritatis natus a voluptatem placeat deleniti molestias dolor! Eaque autem numquam dolore! Cumque magnam omnis, necessitatibus soluta praesentium sequi minus voluptatem!</v-card-text>
                </v-card>
            </v-col>
            <v-col col=12 md=4 sm=12>
                <v-card>
                    <v-card-title>text</v-card-title>
                    <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam veritatis natus a voluptatem placeat deleniti molestias dolor! Eaque autem numquam dolore! Cumque magnam omnis, necessitatibus soluta praesentium sequi minus voluptatem!</v-card-text>
                </v-card>
            </v-col>
            <v-col col=12 md=4 sm=12>
                <v-card>
                    <v-card-title>text</v-card-title>
                    <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam veritatis natus a voluptatem placeat deleniti molestias dolor! Eaque autem numquam dolore! Cumque magnam omnis, necessitatibus soluta praesentium sequi minus voluptatem!</v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    created() {
        this.$store.commit("SET_ROOTURL", this.$route.name, { root: true });
    },
}
</script>