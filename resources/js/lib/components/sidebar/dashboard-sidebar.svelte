<script lang="ts">
    import { Link, usePage } from '@inertiajs/svelte';
    import * as Sidebar from '$lib/components/ui/sidebar/index.js';
    import UserAvatar from '../user/user-avatar.svelte';
    import UserDropdown from '../user/user-dropdown.svelte';
    import { useSidebarMenuItems } from './use-sidebar-menu-items';

    const props = usePage().props;

    // Menu items.
    const items = useSidebarMenuItems(props.auth.user.role);
    const pathname = $derived(window.location.pathname);
</script>

<Sidebar.Root collapsible="icon">
    <Sidebar.Content>
        <Sidebar.Group>
            <Sidebar.GroupLabel>Application</Sidebar.GroupLabel>
            <Sidebar.GroupContent>
                <Sidebar.Menu>
                    {#each items as item (item.title)}
                        <Sidebar.MenuItem>
                            <Sidebar.MenuButton
                                variant={item.url == pathname
                                    ? 'primary'
                                    : 'default'}
                            >
                                {#snippet child({ props })}
                                    <Link href={item.url} {...props}>
                                        <item.icon />
                                        <span>{item.title}</span>
                                    </Link>
                                {/snippet}
                            </Sidebar.MenuButton>
                        </Sidebar.MenuItem>
                    {/each}
                </Sidebar.Menu>
            </Sidebar.GroupContent>
        </Sidebar.Group>
    </Sidebar.Content>
    <Sidebar.Footer>
        <UserDropdown>
            <Sidebar.MenuItem>
                <Sidebar.MenuButton>
                    <UserAvatar class="size-6" />
                    {props.auth.user.name}
                </Sidebar.MenuButton>
            </Sidebar.MenuItem>
        </UserDropdown>
    </Sidebar.Footer>
</Sidebar.Root>
