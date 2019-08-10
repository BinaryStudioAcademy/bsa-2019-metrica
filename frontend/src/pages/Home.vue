<template>
    <VContent>
        <VLayout wrap>

            <VFlex left-col-wrapper sm12 md6>
                <VLayout 
                    column 
                    align-items-start
                    justify-center
                    left-col
                    >
                    <h1>Get to know  your customers.</h1>
                    <div class="btn-group">
                        <VBtn 
                            class="start"
                            color="primary"
                            x-large
                            >
                            Start fo free
                        </VBtn>                    
                        <VBtn
                            class="login"
                            to="/login"
                            outlined
                            min-width="150px"
                            x-large
                            >
                            Sign In
                        </VBtn>
                    </div>
                </VLayout>
            </VFlex>

            <VFlex image sm12 md6>
                <VImg 
                    src="/assets/images/man.png"
                    alt="Man"
                    >
                </VImg>
            </VFlex>

        </VLayout>
    </VContent>
</template>

<style lang="scss" scoped>

main {
    background: #FFFFFF;
    margin-top: 40px;    
}

.v-btn {
    margin-right: 20px;
    font-family: Gilroy;
    font-size: 18px;
    line-height: 22px;
    letter-spacing: 0.4px;
    text-transform: none;
    border-radius: 3px;

    +.start {
        background: #3C57DE;
    }
    +.login {
        background: #FFFFFF;
        border: 2px solid #3C57DE;
        box-sizing: border-box;
        border-radius: 3px;
        color: #3C57DE;
    }
}

.left-col-wrapper {
    padding-left: 10%;
}


h1{
    font-family: Gilroy;
    font-size: 55px;
    line-height: 65px;
    margin-bottom: 60px;
}

.left-col {
    height: 100%;
    background: #FFFFFF;
}

</style>