<script>

export default {
    created(el, binding){
        const user_permissions = binding.value.props.auth.permissions;

        const found = binding.value.permissions.find(permission => {
            return user_permissions.some(e => e.name === permission)
        });

        if (!found){ // no match
            el.style.display = "none";
        }
    }
}
</script>
