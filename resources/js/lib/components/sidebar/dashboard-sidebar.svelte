<script lang="ts">
    import * as Sidebar from '$lib/components/ui/sidebar/index.js';
    import { Link, usePage } from '@inertiajs/svelte';
    import { useSidebarMenuItems } from './use-sidebar-menu-items';
    import UserAvatar from '../user/user-avatar.svelte';
    import UserDropdown from '../user/user-dropdown.svelte';
    import { ChevronsDownUp } from '@lucide/svelte';
    import { buttonVariants } from '../ui/button';

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
                            <Sidebar.MenuButton>
                                {#snippet child({ props })}
                                    <Link
                                        href={item.url}
                                        {...props}
                                        class={`flex w-full justify-normal items-center ${buttonVariants({ variant: pathname === item.url ? 'default' : 'ghost' })}`}
                                    >
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
            <Sidebar.MenuItem
                class={`flex justify-between items-center w-full p-6 px-2 ${buttonVariants({ variant: 'outline' })}`}
            >
                <div class="flex gap-2 items-center">
                    <UserAvatar />
                    <span class="text-sm text-muted-foreground">
                        {props.auth.user.name}
                    </span>
                </div>
                <ChevronsDownUp class="size-3.5 text-muted-foreground" />
            </Sidebar.MenuItem>
        </UserDropdown>
    </Sidebar.Footer>
</Sidebar.Root>
